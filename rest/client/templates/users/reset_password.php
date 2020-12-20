<article id="change-password">
    <form onsubmit="return onSubmit_resetPasswordNew(this)">
        <header>
            <h1>Change Password</h1>
        </header>
        <label>New Password:
            <input type="password" id="pwd" name="pwd" placeholder="Password" required></label>
        <label> Repeat Password:
            <input type="password" id="rpt_pwd" placeholder="Password" required></label>
        <input type="submit" value="Submit" id="submit-password">
    </form>
</article>
<script>
    function onSubmit_resetPasswordNew(el){
        if(!signup_check()) return false;

        let token = "<?= $_GET['token'] ?>";
        let password = el.querySelector('input[name="pwd"]').value;

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
                console.error(response);
            }
        })
        .catch(function (error){
            console.error(error);
        });

        return false;
    }
</script>
