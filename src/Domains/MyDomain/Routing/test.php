<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Test</title>
    <head>

    <body>
        <p>Test</p>
        <?php
foreach ($allExamples as $example)
{
        ?>
        <p>field1 : <?= $example->getField1() ?>, field2 : <?= $example->getField2() ?>
            <a href="example/<?= $example->getId() ?>">Détail</a>
            <a href="remove-example/<?= $example->getId() ?>">Supprimer</a>
        </p>
        <?php
}
        ?>

        <h1>Ajouter un « Example »</h1>
        <form action="add-example" method="POST">
            <label>
                Field1 :
                <input type="text" name="field1">
            </label>
            <label>
                Field2 :
                <input type="text" name="field2">
            </label>
            <input type="submit">
        </form>
    </body>

</html>
