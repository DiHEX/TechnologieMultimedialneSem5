<h2>Jak do nas dotrzeć</h2>

<?php

$subpage_name = "how-to-reach-us";
$connection = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie16");
$select_query = $connection->prepare("SELECT html_contents FROM contents WHERE subpage_name=?");
$select_query->bind_param("s", $subpage_name);
$select_query->bind_result($how_to_reach_us);
$select_query->execute();
$select_query->fetch();
?>

<iframe width="600" height="450" style="border: 1px solid black;" loading="lazy" allowfullscreen
        referrerpolicy="no-referrer-when-downgrade"
        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCXK6L3YJd9XTmL66m5diLsuOMsmXpM7l4&q=<?php echo $how_to_reach_us; ?>">
</iframe>

<?php if(isset($_SESSION["is-admin"])) { ?>
    <form method="post" action="/zadanie16/actions/page-edit.php">
        <label>Wpisz nowy adres firmy:</label>

        <input type="text" max="50" class="form-control" value="<?php echo $how_to_reach_us; ?>" name="html-contents" />

        <input type="hidden" value="<?php echo $subpage_name; ?>" name="subpage-name" />

        <div style="margin-top: 5px;">
            <input type="submit" value="Zapisz" class="btn btn-primary btn-sm" />
        </div>
    </form>

    <script>
        $('#html-editor').trumbowyg();
    </script>
<?php } ?>