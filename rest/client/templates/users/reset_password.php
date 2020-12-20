<article id="change-password">
    <form onsubmit="return onSubmit_resetPasswordNew(this)">
        <header>
            <h1>Change Password</h1>
        </header>
        <label>New Password:
            <input type="password" id="pwd" name="pwd" placeholder="Password" required></label>
        <label> Repeat Password:
            <input type="password" id="rpt_pwd" placeholder="Password" required></label>
        <?php if(isset($_GET['failed']) && isset($_GET['errorCode'])) { ?>
            <p id="simple-fail-msg">Change password failed! - <?= $errorsArray[$_GET['errorCode']] ?></p>
        <?php } ?>
        <input type="submit" value="Submit" id="submit-password">
    </form>
</article>
<script>
    function onSubmit_resetPasswordNew(el){
        if(!signup_check()) return false;

        let token = "<?= $_GET['token'] ?>";
        let password = el.querySelector('input[name="pwd"]').value;

        var thisRegex = new RegExp('^(?=.*[!@#$%^&*)(+=._-])(?=.*[A-Z])(?=.{7,}).*$');

        if(!thisRegex.test(password)){
            document.querySelector('p').remove();
            let errorMsg = document.createElement('p');
            let errorString = "Password needs be at least 7 characters long and contain at least one uppercase letter and 1 special character.";
            errorMsg.id = 'simple-fail-msg';
            errorMsg.innerHTML = errorString;
            if(document.querySelector('form').lastElementChild.previousElementSibling.innerHTML != errorString)
                document.querySelector('form').insertBefore(errorMsg, document.querySelector('form').lastElementChild);
            return false;
        }

        api.put(
            "user/<?= $user->getUsername() ?>/password",
            {
                token: token,
                password: password
            }
        )
        .then(function (response){
            if(response.status === 200){
                location.href = "login/";
            } else {
                location.href = `user/<?= $user->getUsername() ?>/password/change/?token=` + token + `&failed=1&errorCode=5`;
            }
        })
        .catch(function (error){
            console.error(error);
        });

        return false;
    }
</script>
