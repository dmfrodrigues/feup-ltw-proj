<article id="adoption-request">
    <header>
        <h1>Adoption Request</h1>
    </header>
    <section id="proposal-request">
        <h3>Please enter a proposal message:</h3>
        <form action="actions/add_proposal.php?id=<?= $pet->getId() ?>" method="post">
            <textarea name="description" rows="10" cols="50"></textarea>
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <input type="submit" value="Submit" id="add-proposal-submit">
        </form>
    </section>
</article>