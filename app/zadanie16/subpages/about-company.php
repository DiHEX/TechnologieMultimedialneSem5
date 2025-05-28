<h2>O firmie</h2>

<?php

$subpage_name = "about-company";
$connection = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie16");
$select_query = $connection->prepare("SELECT html_contents FROM contents WHERE subpage_name=?");
$select_query->bind_param("s", $subpage_name);
$select_query->bind_result($html_contents);
$select_query->execute();
$select_query->fetch();
?>

<?php if (isset($_SESSION["is-admin"])) { ?>
    <form method="post" action="/zadanie16/actions/page-edit.php">
        <textarea id="html-editor" name="html-contents">
            <?php echo $html_contents; ?>
        </textarea>

        <input type="hidden" value="<?php echo $subpage_name; ?>" name="subpage-name" />

        <input type="submit" value="Zapisz" class="btn btn-primary" />
    </form>

    <script>
        $('#html-editor').trumbowyg();
    </script>
<?php } else { ?>
    <?php echo $html_contents; ?>
<?php } ?>
