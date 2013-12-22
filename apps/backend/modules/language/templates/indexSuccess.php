<h1>Languages List</h1>

<table border="1">
  <thead>
    <tr>
      <td><h3>Culture</h3></td>
      <td><h3>Name</h3></td>
      <td><h3>Preferred currency</h3></td>
      <td><h3>#</h3></td>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($languages as $language): ?>
    <tr>
      <td><?php echo $language->getCulture() ?></td>
      <td><?php echo $language->getName() ?></td>
      <td><?php echo $language->getPrefferredCurrency() ?></td>
      <td>
          <?php echo link_to(image_tag('/images/icons/edit.png'),'language/edit?culture='.$language->getCulture())?>
          <?php echo link_to(image_tag('/images/icons/cross.png'), 'language/delete?culture='.$language->getCulture(), array('method' => 'delete', 'confirm' => 'Are you sure?'))?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
