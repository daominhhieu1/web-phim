$(function() {

    $('#login-form-link').click(function(e) {
        $("#login-form").delay(100).fadeIn(100);
        $("#register-form").fadeOut(100);
        $('#register-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });
    $('#register-form-link').click(function(e) {
        $("#register-form").delay(100).fadeIn(100);
        $("#login-form").fadeOut(100);
        $('#login-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });

});
function passwordChanged() {
    var strength = document.getElementById('strength');
    var strongRegex = new RegExp("^(?=.{16,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
    var mediumRegex = new RegExp("^(?=.{10,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
    var enoughRegex = new RegExp("(?=.{6,}).*", "g");
    var pwd = document.getElementById("password");
    if (false == enoughRegex.test(pwd.value)) {
        strength.innerHTML = '<span style="color:black;padding-top: 13px;">Kém</span>';
    } else if (strongRegex.test(pwd.value)) {
        strength.innerHTML = '<span style="color:green;padding-top: 13px;">Mạnh</span>';
    } else if (mediumRegex.test(pwd.value)) {
        strength.innerHTML = '<span style="color:orange;padding-top: 13px;">Bình Thường</span>';
    } else {
        strength.innerHTML = '<span style="color:red;padding-top: 13px;">Yếu</span>';
    }
}
window.onload = function(){
    var inputs = document.forms['register-form'].getElementsByTagName('input');
    var login = document.forms['login-form'].getElementsByTagName('input');
    var run_onchange = false;
    function valid_register(){
        var errors = false;
        var reg_mail = /^[A-Za-z0-9]+([_\.\-]?[A-Za-z0-9])*@[A-Za-z0-9]+([\.\-]?[A-Za-z0-9]+)*(\.[A-Za-z]+)+$/;
        var reg_user = /^[A-Za-z0-9_]+([_\.\-]?[A-Za-z0-9])$/;
        var reg_pass = /^(?=.*\d)(?=.*[a-zA-Z])[a-zA-Z0-9!@#$%&*]{10,}$/;
        for(var i=0; i<inputs.length; i++){
            var value = inputs[i].value;
            var id = inputs[i].getAttribute('id');

            // Tạo phần tử span lưu thông tin lỗi
            var span = document.createElement('span');
            // Nếu span đã tồn tại thì remove
            var p = inputs[i].parentNode;
            if(p.lastChild.nodeName == 'SPAN') {p.removeChild(p.lastChild);}

            // Kiểm tra rỗng
            if(value == ''){
                span.innerHTML ='<span style="color:red;padding-top: 13px;">Chưa nhập đầy đủ dữ liệu!</span>';
            }else{
                // Kiểm tra các trường hợp khác
                if(id == 'email'){
                    if(reg_mail.test(value) == false){ span.innerHTML ='<span style="color:red;padding-top: 13px;">Email không hợp lệ</span>';}
                }
                // Kiểm tra password
                if(id == 'password'){
                    if(reg_pass.test(value) == false){span.innerHTML ='<span style="color:red;padding-top: 13px;">Mật khẩu phải ít nhất 10 ký tự và có chữ hoa, chữ thường và số,kí tự đặc biệt</span>';}
                    var pass = value;
                }
                // Kiểm tra password nhập lại
                if(id == 'confirm_password' && value != pass){span.innerHTML ='<span style="color: red;padding-top: 13px;">Password nhập lại chưa đúng</span>';}
                // Kiểm tra username
                if(id == 'username'){
                    if(reg_user.test(value) == false){ span.innerHTML ='<span style="color: red;padding-top: 13px;">Username không hợp lệ</span>';}
                    // var email =value;
                }
            }

            // Nếu có lỗi thì span vào hồ sơ, chạy onchange, submit return false, highlight border
            if(span.innerHTML != ''){
                inputs[i].parentNode.appendChild(span);
                errors = true;
                run_onchange = true;
                inputs[i].style.border = '1px solid #c6807b';
                inputs[i].style.background = '#fffcf9';

            }
        }// end for

        //if(errors == false){alert('Đăng ký thành công');window.location.replace('index.phtml');}
        return !errors;
    }// end valid()



    // Chay ham kiem tra
    var register = document.getElementById('register-submit');
    register.onclick = function(){
        return valid_register();
    }


    // Kiểm tra lỗi với sự kiện onchange -> gọi lại hàm valid_register()
    for(var i=0; i<inputs.length; i++){
        var id = inputs[i].getAttribute('id');
        inputs[i].onchange = function(){
            if(run_onchange == true){
                this.style.border = '1px solid #999';
                this.style.background = '#fff';
                valid_register();
            }
        }
    }// end for
}// end onload
function validateForm(){
    // Bước 1: Lấy giá trị của username và password
    var reg_user = /^[A-Za-z0-9_]+([_\.\-]?[A-Za-z0-9])$/;
    var reg_pass = /^[A-Za-z0-9]{10,}?[!@#$%^&*_+]$/;
    var username = document.getElementById('username-login').value;
    var password = document.getElementById('password-login').value;

    // Bước 2: Kiểm tra dữ liệu hợp lệ hay không
    console.log(username);
    if (username == '' || password == '') {
        if(reg_user.test(username) == false){
            alert("Username không hợp lệ");
        }
        if(reg_pass.test(password) == false){
            alert("Mật khẩu phải ít nhất 10 ký tự và có chữ hoa, chữ thường và số");
        }
    }
    return false;
}
