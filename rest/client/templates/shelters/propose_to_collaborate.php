<article id="collaboration-proposal">
    <header>
        <h1>Collaboration Proposal</h1>
    </header>
    <section id="collaboration-proposal-body">
        <h3>Please enter a proposal message:</h3>
        <form action="actions/propose_to_collaborate.php?username=<?= $user->getUsername() ?>" method="post">
            <textarea name="description" rows="10" cols="50"></textarea>
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <input type="submit" value="Submit" id="collaboration-proposal-submit">
        </form>
    </section>
</article>