Dobrodosli u ispis  MVC-AVIONI
<br>

<?php foreach($data['resources'] as $key=>$data1)
{ ?>

        <strong>
            <br>
            <?= htmlspecialchars( $data1['resourcesId'])?>.<?= htmlspecialchars( $data1['url'])?>

        </strong>
            <br>

        Metoda:       <?= htmlspecialchars( $data1['method'])?>
        <br>
        Description:    <?=htmlspecialchars( $data1['description'])?>
        <br>
<?php
}

?>
<br>
<br>
<?php

include('dokumentacija.html')
?>


