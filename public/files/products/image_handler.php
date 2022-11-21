<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

	// kapott paraméterek
	#preg_match ("/.*\/([0-9a-z]{1,16})\/([0-9a-zA-z_\-]{1,64}\.[a-zA-z]{1,4})(\?([0-9a-f]{32})$|$)/", $_SERVER["REQUEST_URI"], $found);

    //pl.: /files/products/images/small/fajlnev.jpg
    $reg_exp = "/.*"; //full path
    $reg_exp .= "\/([0-9a-z]{1,16})"; //verzió
    $reg_exp .= "\/([0-9a-zA-z_\-\(\)\+]{1,64}\.[a-zA-z]{1,4})"; //fájlnév
    $reg_exp .= "(\?([0-9a-f]{32})$|$)/"; //auth

    preg_match ($reg_exp, $_SERVER["REQUEST_URI"], $found);

	$version   = $found[1];
	$filename  = $found[2];
	$auth      = $found[3];

	// ha nem megfelelőek az értékek...
	if ( ! is_dir ($version))
	{
		error("1");
	}

	if ( ! is_file ($version . "/.htconfig"))
	{
	    error("1.1");
	}

	if($version == "original")
	{
	    error("1.2");
	}

	// konfiguráció olvasása
	$vdata = read_config ($version);

	// verzió jelszavas védelme
	if ( ! empty($vdata["passwd"]) && md5 ($version . "/" . $filename . "/" . $vdata["passwd"]) != $auth)
	{
	    error ("2");
	}


	// kép(ek) ellenőrzése
	check_image ("original/" . $filename);
	if ( ! empty($vdata["under"]))
		check_image ($vdata["under"]);
	if ( ! empty($vdata["over"]))
		check_image ($vdata["over"]);

	// minimálisan szükséges paraméterek ellenőrzése
	if ( empty($vdata["forcedw"]) && empty($vdata["maxw"]) || empty($vdata["forcedh"]) && empty($vdata["maxh"]))
		error("3");

	// plusz memória a konvertáláshoz
    ini_set('memory_limit', '128M');
    set_time_limit(0);
    ignore_user_abort(TRUE);

	// verzió legyártása, mentése, küldése
	convert ($vdata, $version, $filename);

	function convert ($vdata, $version, $filename) {

		// eredeti kép betöltése
		$image = load_image ("original/" . $filename);

		// eredeti méretek
		$w = imagesx ($image);
		$h = imagesy ($image);

		// új méret számítása
		if ( ! empty($vdata["forcedw"]) && empty($vdata["forcedh"])) {

			// fix szélesség
			$new_width = $vdata["forcedw"];
			$new_height = min ($h * ($vdata["forcedw"] / $w), $vdata["maxh"]);

		} else if ( ! empty($vdata["forcedh"]) && empty($vdata["forcedw"])) {

			// fix magasság
			$new_width = min ($w * ($vdata["forcedh"] / $h), $vdata["maxw"]);
			$new_height = $vdata["forcedh"];

		} else if ( ! empty($vdata["forcedw"]) &&  ! empty($vdata["forcedh"])) {

			// fix méretek
			// csak akkor méretezzük át ha nagyobb a kép, mint a fix méretek
			/**
			 * fw:194
			 * fh:194
			 * w:775
			 * h:477
			 */
            $ratio_w = $w / $vdata["forcedw"];
            $ratio_h = $h / $vdata["forcedh"];

            if($ratio_w >= 1 && $ratio_h >= 1)
            {
                //ha mindkét méret nagyobb, vagy egyenlő, akkor levágjuk a fix méretre
                $new_width = $vdata["forcedw"];
                $new_height = $vdata["forcedh"];
            }
            else if($ratio_w < 1 && $ratio_h < 1)
            {
                //mindkettő kisebb, nem méretezzük át
                $new_width = $w;
                $new_height = $h;
            }
            else
            {
                //valamelyik kisebb, átméretezzük az arány megtartásával
                $new_width = min ($w / $ratio_h, $vdata["forcedw"]);
                $new_height = min ($h / $ratio_w, $vdata["forcedh"]);
            }

		} else {

			// laza méretezés (maximális méretek)
			// csak akkor méretezzük át, ha nagyobb a kép, mint a megengedett
            $ratio_w = $vdata["maxw"] / $w;
            $ratio_h = $vdata["maxh"] / $h;

            if($ratio_w < 1 OR $ratio_h < 1)
            {
                $ratio = min($ratio_w, $ratio_h);

                $new_width = $w * $ratio;
                $new_height = $h * $ratio;
            }
            else
            {
                $new_width = $w;
                $new_height = $h;
            }
		}

		// cél filenév
		$pathname = $version . "/" . $filename;

		// minőség
		$qual = ! empty($vdata["quality"]) ? (int)$vdata["quality"] : "60";

		// filter alkalmazása
		if ( ! empty($vdata["filter"])) {
			$filter = config_array ($vdata["filter"]);
			imagefilter ($image, $filter[0], $filter[1], $filter[2], $filter[3]);
		}

		// tényleges képműveletek
		$vals = @getimagesize("original/" . $filename);
		@create_version ($image, $new_width, $new_height, $pathname, $qual, $vdata["under"], $vdata["over"], $vdata["bordersafe"], $vdata["attachment"], $vals);

		// eredmény visszaküldése a böngészőbe
		header ('HTTP/1.1 200 OK');
		header ("Content-type: {$vals['mime']}");
		readfile ($pathname);
		exit();
	}

	function create_version ($image, $new_width, $new_height, $pathname, $qual, $under = false, $over = false, $bordersafe = false, $attachment = "", $vals = array()) {

		// eredet képméret
		$w = imagesx ($image);
		$h = imagesy ($image);

		// méretezés aránya
		$ratio = min ($w / $new_width, $h / $new_height);

		// ezzel a beállítással az eredeti kép 10%át (keret) eldobjuk
		if ($bordersafe)
			$ratio *= .9;

		// a fuggolegesen kimarado resz (szigoru meretezes, azaz vagas eseten) milyen aranyban oszoljon meg a kep felett es alatt,
		// azaz allo kepeknel (portre) megprobaljuk nem levagni a fejet
		$partabove = ($h >= $w * 5 / 4) ? 4 : 2;

		// uj kep objektum
		$im2 = imagecreatetruecolor ($new_width, $new_height);

        /*
		// hatter zoldre festese - egyertelmu legyen ha problema az atlatszo (attetszo) kep
		imagealphablending ($im2, true);
		$bg = imagecolorallocate ($im2, 0, 255, 0);
		imagefilledrectangle ($im2, 0, 0, $new_width, $new_height, $bg);
		*/

        $bg = imagecolorallocate($im2, 255, 255, 255);

		if($vals[2] == 3)
		{
		    // PNG kép átlátszóság.
            imagealphablending($im2, false);
            imagesavealpha($im2, true);
            imagealphablending($image, true);
		}

		//also reteg: hatter
		if ($under) {
			$im3 = load_image ($under);
			copy_attached ($im2, $im3, $attachment);
			imagedestroy ($im3);
		}

		// meretezes + masolas + vagas
		imagecopyresampled ($im2, $image, 0, 0, ($w - $new_width * $ratio) / 2, ($h - $new_height * $ratio) / $partabove, $new_width, $new_height, $new_width * $ratio, $new_height * $ratio);

		// fedo reteg
		if ($over) {
			$im3 = load_image ($over);
			copy_attached ($im2, $im3, $attachment);
			imagedestroy ($im3);
		}

		$watermark_file = '../editor/watermark.png';
		if( is_file( $watermark_file ) )
		{
			$watermark = imagecreatefrompng( $watermark_file );

			if( imagesx( $im2 ) < imagesx( $watermark ) || imagesy( $im2 ) < imagesy( $watermark ) ) {
				$ratio = imagesx( $im2 ) / imagesx( $watermark );
				$wm_size[0] = imagesx( $watermark ) * $ratio;
				$wm_size[1] = imagesy( $watermark ) * $ratio;
				$watermark = imagescale( $watermark, $wm_size[0], $wm_size[1] );
			}

			// Pozícionálás
			$position = 'center';
			switch( $position ) {
				// jobb-felül
				case 'right-top':	 $wm_pos = array( ( imagesx( $im2 ) - imagesx( $watermark ) ), 0 ); break;
				// jobb-lent
				case 'right-bottom':  $wm_pos = array( ( imagesx( $im2 ) - imagesx( $watermark ) ), ( imagesy( $im2 ) - imagesy( $watermark ) ) ); break;
				// bal-alul
				case 'left-bottom':   $wm_pos = array( 0, ( imagesy( $im2 ) - imagesy( $watermark ) ) ); break;
				// bal-felül
				case 'left-top':	  $wm_pos = array( 0, 0 ); break;
				// közép-felül
				case 'center-top':	$wm_pos = array( ( imagesx( $im2 ) - imagesx( $watermark ) ) / 2, ( imagesy( $im2 ) - imagesy( $watermark ) ) / 4 ); break;
				// középre
				default:			  $wm_pos = array( ( imagesx( $im2 ) - imagesx( $watermark ) ) / 2, ( imagesy( $im2 ) - imagesy( $watermark ) ) / 2 );
			}

			imagecopy( $im2, $watermark, $wm_pos[0], $wm_pos[1], 0, 0, imagesx( $watermark ), imagesy( $watermark ) );
		}
		// mentes
        switch ($vals[2]) {
            case 1: imagegif($im2, $pathname); break;
            case 2: imagejpeg($im2, $pathname, $qual); break;
            case 3: imagepng($im2, $pathname); break;
            default: imagejpeg($im2, $pathname, $qual); break;
        }

		// tisztitas
		imagecolordeallocate ($im2, $bg);
		imagedestroy ($im2);
	}


	function copy_attached ($dst, $src, $attachment) {
		// alap koordinatak
		$dstx = 0;
		$dsty = 0;

		// meretek
		$srcw = imagesx ($src);
		$srch = imagesy ($src);
		$dstw = imagesx ($dst);
		$dsth = imagesy ($dst);

		// horizontalis (vizsintes) igazitas
		if (preg_match ("/[cC]/", $attachment)) {

			// kozepre
			$dstx = (int)(($dstw - $srcw) / 2);

		} else if (preg_match ("/[rR]/", $attachment)) {

			// jobbra
			$dstx = $dstw - $srcw;

		}

		// vertikalis (fuggoleges) igazitas
		if (preg_match ("/[mM]/", $attachment)) {

			// kozepre
			$dsty = (int)(($dsth - $srch) / 2);

		} else if (preg_match ("/[bB]/", $attachment)) {

			// jobbra
			$dsty = $dsth - $srch;

		}

		// masolas a celkoordinatakra
		imagecopy ($dst, $src, $dstx, $dsty, 0, 0, $srcw, $srch);
	}


	function check_image ($pathname) {

		// file letezik?
		if (!is_file ($pathname))
			error("File not found: {$pathname}");

		// megfelelo formatum?
		$info = getimagesize($pathname);

		if (!in_array ($info[2], array (1, 2, 3)))
			error("5");
	}


	function load_image ($pathname) {

		// file tipusa
		$info = getimagesize ($pathname);
		$type = $info[2];

		// betoltes (tipus szerint)
		if ($type == 1) {
			return imagecreatefromgif ($pathname);
		} else if ($type == 2) {
			return imagecreatefromjpeg ($pathname);
		} else if ($type == 3) {
			return imagecreatefrompng ($pathname);
		} else {
			error("6");
		}
	}

	// konfiguracios file (.config) olvasasa
	function read_config ($dir) {
		$vdata = array ();

		$lines = file ($dir . "/.htconfig");
		foreach ($lines as $line) {
			$match = preg_match ("/([a-z0-9_]+):(.*)$/", trim ($line), $found);
			if ($match)
				$vdata[$found[1]] = trim ($found[2]);
		}

		return $vdata;
	}

	// tomb megfejtese a config filebol
	function config_array ($from) {
		$ex = explode (",", $from);
		foreach ($ex as $token) {
			if (($t = trim ($token))) {
				$ret[] = is_numeric ($t) ? $t : constant ($t);
			}
		}
		return $ret;
	}

	// egyszeru 404 barmilyen hiba eseten
	function error ($msg = false) {
		header ('HTTP/1.1 404 Not Found');
		echo ('<html><title>404 Not Found</title><body><h1>Not Found</h1>Image conversion not possible, error: ' . $msg . '<br>');
		if ($msg) {
			$ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER["HTTP_REFERER"] : '';
			trigger_error ($msg . ' "' . $_SERVER["REQUEST_URI"] . '" "' . $ref . '"');
		}
		echo ('</body></html>');
		exit ();
	}
