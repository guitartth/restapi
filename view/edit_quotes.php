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
        <select name="authorId">
            <option value="0">Select Author</option>
            <?php foreach ($authors as $author) : ?>
            <?php if ($authorId == $author['authorId']) { ?>
                <option value="<?= $author['authorId'] ?>" selected>
                    <?php } else { ?>
                <option value="<?= $author['authorId'] ?>">
                    <?php } ?>
                    <?= $author['author'] ?>
                </option> 
                <?php endforeach; ?>
        </select>

        <select name="categoryId">
        <option value="0">Select Category</option>
        <?php foreach ($categories as $category) : ?>
        <?php if ($categoryId == $category['categoryId']) { ?>
            <option value="<?= $category['categoryId'] ?>" selected>
                <?php } else { ?>
            <option value="<?= $category['categoryId'] ?>">
                <?php } ?>
                <?= $category['category'] ?>
            </option> 
            <?php endforeach; ?>
        </select>
        </div>
        <br>

        <label>Quote:</label>
        <textarea type="text" name="quote_name" maxLength="200" rows="4" cols="50" required>
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

