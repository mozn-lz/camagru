<div class="<?php echo $type; ?>"><?php echo $message; ?></div>
<?php
if (isset($_GET['danger'])) {
    echo "<div class='danger'>".$_GET['danger']." </div>";
} elseif (isset($_GET['caution'])) {
    echo "<div class='caution'>".$_GET['caution']." </div>";
} elseif (isset($_GET['success'])) {
    echo "<div class='success'>".$_GET['success']." </div>";
}else {
    
}
?>