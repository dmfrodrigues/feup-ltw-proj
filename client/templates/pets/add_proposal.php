<article id="adoption-request">
    <header>
        <h1>Adoption Request</h1>
    </header>
    <section id="proposal-message">
        <h3>Please enter a proposal message:</h3>
        <form action="action_add_proposal.php?id=<?= $pet['id'] ?>" method="post">
            <textarea name="description"></textarea>
            <input type="submit" value="Submit" id="add-proposal-submit">
    </section>
</article>