<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Page;

class ContactController extends Controller
{

    /**
     * Display a contact page
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $data['page']               = Page::getPageByType('contact');
        $data['meta_title']         = !empty($data['page']['menu_title']) ? $data['page']['menu_title'] : $data['page']['name'];
        $data['meta_description']   = $data['page']['meta_description'];
        $data['meta_keywords']      = $data['page']['meta_keywords'];
        return view('contact', $data);
    }

    public function storeContactForm(Request $request)
    {
        //  Send mail to admin
        \Mail::send('contactMail', array(
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'subject' => $request['subject'],
            'message' => $request['message'],
        ), function($message) use ($request){
            $message->from($request->email)
                    ->to(SHOP_MAIL, SHOP_NAME)
                    ->subject($request->subject);
        });

        return redirect()->back()->with(['success' => 'Contact Form Submit Successfully']);
    }
}
