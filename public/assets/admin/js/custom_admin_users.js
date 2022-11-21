$(document).ready(function() {
	
	$("#account_form").validate(
	{
		errorClass: 'alert-danger',
		errorElement: "code",
		rules: {
			email: {
				required : true, 
				/*email:true, 
				remote: {
					url: base_url+"admin/users/check_user_email",
					type: "post"
				}*/
			},
			group_id: {required : true},
			name: {required : true},
			password: {required : true, minlength: 6},
			confirm_password: {required : true, equalTo: "#password"},
			
		},
		messages:{
			email: {required : 'Email cím megadása kötelező', email:'Nem valós email cím',  /*remote: "Ez az email cím már létezik!"*/},
			password: {required : 'Jelszó megadása kötelező!', minlength: 'A jelszó minimum 6 karakter hosszú kell legyen'},
			confirm_password: {required : 'Jelszó megerősítése kötelező!', equalTo:"A két jelszó nem egyezik"},
			group_id: {required : 'Csoport kiválasztása kötelező'},
			name: {required : 'Név megadása kötelező'},
		}
	});
	
	$("#edit_account_form").validate(
	{
		errorClass: 'alert-danger',
		errorElement: "code",
		rules: {
			email: {required : true},
			group_id: {required : true},
			name: {required : true},
			password: {},
			confirm_password: {equalTo: "#password"},
			
		},
		messages:{
			email: {required : 'Email cím megadása kötelező', email:'Nem valós email cím',  /*remote: "Ez az email cím már létezik!"*/},
			password: {required : 'Jelszó megadása kötelező!', minlength: 'A jelszó minimum 6 karakter hosszú kell legyen'},
			confirm_password: {required : 'Jelszó megerősítése kötelező!', equalTo:"A két jelszó nem egyezik"},
			group_id: {required : 'Csoport kiválasztása kötelező'},
			name: {required : 'Név megadása kötelező'},
		}
	});
	
	$("#admin_gropus_form").validate(
	{
		errorClass: 'alert-danger',
		errorElement: "code",
		rules: {
			title: {required : true},
		},
		messages:{
			title: {required : 'A csoport címének megadása kötelező'},
		}
	});
});