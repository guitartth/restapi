<?php
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: edit_quotes.php
?>


<?php // Site Header
include('header.php'); ?>

<section id="add_quote">
    <form action="." method="post" id="add_form">
        <input type="hidden" name="action" value="add_quote">
        <div id="add_quote_input">
        <select name="author_id">
            <option value="0">Select Author</option>
            <?php foreach ($authors as $author) : ?>
            <?php if ($author_id == $author['id']) { ?>
                <option value="<?= $author['id'] ?>" selected>
                    <?php } else { ?>
                <option value="<?= $author['id'] ?>">
                    <?php } ?>
                    <?= $author['author'] ?>
                </option> 
                <?php endforeach; ?>
        </select>

        <select name="category_id">
        <option value="0">Select Category</option>
        <?php foreach ($categories as $category) : ?>
        <?php if ($category_id == $category['id']) { ?>
            <option value="<?= $category['id'] ?>" selected>
                <?php } else { ?>
            <option value="<?= $category['id'] ?>">
                <?php } ?>
                <?= $category['category'] ?>
            </option> 
            <?php endforeach; ?>
        </select>
        </div>
        <br>

        <label>Quote:</label>
        <textarea type="text" name="quote" maxLength="200" rows="4" cols="50" required>
        </textarea>

        <div class="add_quote_submit_button">
            <button class="add_button">Add</button>
        </div>
    </form>
</section>

<?php // Link to Index and Site Footer ?>
<div id="footer_buttons">
    <form action="." method="post">
        <input type="hidden" name="action" value="default">
        <button class="footer-button">Back Home</button>
    </form>
</div>

<?php include('footer.php'); ?>

