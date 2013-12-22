<h1>Translation words</h1>

<table border="1" width="90%" align="center">
    <tr>
        <td><h3>Id</h3></td>
        <td><h3>Source</h3></td>
        <?php foreach ($i18nLanguages as $language): ?>
        <td><h3><?php echo $language ?></h3></td>
        <?php endforeach; ?>
        <td><h3>#</h3></td>
    </tr>
    <?php foreach ($messages as $id => $message): ?>
    <tr>
        <td><?php echo $id ?></td>
        <td><?php echo $message['source'] ?></td>

            <?php foreach ($i18nLanguages as $sf_culture => $language): ?>
        <td>
                    <?php
                    if (isset($message[$sf_culture]['target']) && $message[$sf_culture]['target'])
                    {
                        echo $message[$sf_culture]['target'];
                    }
                    else
                    {
                        echo $message['source'] . '<span style="color:red;" size="2">(not translated)</span>';
                    } ?>
        </td>
            <?php endforeach; ?>
        <td>
                <?php echo link_to('<img align="absmiddle" src="/images/icons/edit.png" title="Edit" alt="Edit">', "translation/editElement?id=" . $id) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>