<section id="login">
    <header><h2>Reset password</h2></header>
    <form onsubmit="return onSubmit_reset(this.parentNode)">
        <label>
            Username <input type="text" name="username" required>
        </label>
        <input type="submit" class="dark" value="Reset">
    </form>
    <p id="password-reset-notice" style="display: none;">A password reset email was sent</p>
</section>
<script>
    function onSubmit_reset(el){
        let username = el.querySelector('input[name="username"]').value;
        api.put(
            'passwordReset',
            {
                username: username
            }
        )
        .then(function(response){
            el.querySelector('#password-reset-notice').style.display = '';
        })
        .catch(function (error){
            console.log(error);
        });
        return false;
    }

</script>
