<!--
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: list_quotes.php
-->

<?php // Site Header
include('view/header.php'); ?>

<!--Filter Quotes Selection-->
<section id="filter_quote">
    <form action="." method="get" id="add_form">
        <input type="hidden" name="action" value="search_quotes">
        <div id="filter_quote_input">
            <select name="authorId" id="select_author">
                <option value="0">Select Author</option>
                <?php foreach ($authors as $author) : ?>
                    <?php if ($authorId == $author['id']) { ?>
                        <option value="<?= $author['id'] ?>" selected>
                        <?php } else { ?>
                        <option value="<?= $author['id'] ?>">
                        <?php } ?>
                        <?= $author['author'] ?>
                        </option>
                    <?php endforeach; ?>
            </select>

            <select name="categoryId" id="select_category">
                <option value="0">Select Category</option>
                <?php foreach ($categories as $category) : ?>
                    <?php if ($categoryId == $category['id']) { ?>
                        <option value="<?= $category['id'] ?>" selected>
                        <?php } else { ?>
                        <option value="<?= $category['id'] ?>">
                        <?php } ?>
                        <?= $category['category'] ?>
                        </option>
                    <?php endforeach; ?>
            </select><br>
            <button class="search_button">Search</button>
        </div>
    </form>
</section>

<br>
<br>


<!--Quotes Listed-->
<div id="quote_list">
<?php if ($quotes) { ?>
    <?php foreach ($quotes as $quote) : ?>
        <div class="list_row">
            <div class="list_quotes">
                <?= $quote['quote'] ?> 
            <div id="author_list"> - <?= $quote['author'] ?>  </div> 
            </div><br><br>
        </div>
    <?php endforeach; ?>
<?php } else { ?> 
    <p> No quotes exist yet. </p>
<?php } ?>
</div>

<?php // Link to Index/Add Quotes and Site Footer 
?>

<div id="footer_buttons">
    <form action="." method="post">
        <input type="hidden" name="action" value="default">
        <button class="footer_button1">Back Home</button>
    </form>
    <div id="align_buttons">
    <form action="." method="post">
        <input type="hidden" name="action" value="edit_quotes">
        <button class="footer_button2">Add Quote </button>
    </form>
    </div>
</div>
<?php include('view/footer.php'); ?>

