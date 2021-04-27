<?php
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: list_quotes.php
?>

<?php // Site Header
include('view/header.php'); ?>

<!--Filter Quotes Selection-->
<section id="filter_quote">
    <form action="." method="get" id="add_form">
        <input type="hidden" name="action" value="search_quotes">
        <div id="filter_quote_input">
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
            <button class="search_button">Search</button>
        </div>
    </form>
</section>

<br>
<br>

<!--Quotes Listed-->
<?php if ($quotes) { ?>
    <?php foreach ($quotes as $quote) : ?>
        <div class="list_row">
            <div class="list_quotes">
                <?= $quote['quote'] ?> -
                <?= $quote['author'] ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php } else { ?>
    <br>
    <p> No quotes exist yet. </p>
<?php } ?>


<?php // Link to Index/Add Quotes and Site Footer 
?>
<br>
<div id="footer_buttons">
    <form action="." method="post">
        <input type="hidden" name="action" value="default">
        <button class="footer-button">Back Home</button>
    </form>
    
    <form action="." method="post">
        <input type="hidden" name="action" value="edit_quotes">
        <button class="footer-button">Add Quote</button>
    </form>
</div>
<?php include('view/footer.php'); ?>

