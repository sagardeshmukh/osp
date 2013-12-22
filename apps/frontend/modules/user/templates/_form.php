<?php use_stylesheets_for_form($form) ?>

<?php use_javascripts_for_form($form) ?>

    

      <div class="boxContent">

        <div class="boxWrap">

          <div style="padding: 5px;">

          <form action="<?php echo url_for('user/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post">

          <?php if (!$form->getObject()->isNew()): ?>

          <input type="hidden" name="sf_method" value="put" />

          <?php endif; ?>

            <table>

              <tfoot>

                <tr>

                  <td colspan="2">

                    <?php echo $form->renderHiddenFields(false) ?>

                    <input type="submit" value="<?php echo $submit ?>"/>

                    <a href="<?php echo url_for('user/profile')?>">back</a>

                  </td>

                </tr>

              </tfoot>

              <tbody>

                  <tr>

                      <td><?php echo $form['username']->renderLabel() ?></td>

                      <td><?php echo $form['username'] ?></td>

                      <td><?php echo $form['username']->renderError() ?></td>

                  </tr>

                  <tr>

                      <td><?php echo $form['password']->renderLabel() ?></td>

                      <td><?php echo $form['password'] ?></td>

                      <td><?php echo $form['password']->renderError() ?></td>

                  </tr>                  



                  <tr>

                      <td><?php echo $form['email']->renderLabel() ?></td>

                      <td><?php echo $form['email'] ?></td>

                      <td><?php echo $form['email']->renderError() ?></td>

                  </tr>

                  <tr>

                      <td><?php echo $form['firstname']->renderLabel() ?></td>

                      <td><?php echo $form['firstname'] ?></td>

                      <td><?php echo $form['firstname']->renderError() ?></td>

                  </tr>

                  <tr>

                      <td><?php echo $form['lastname']->renderLabel() ?></td>

                      <td><?php echo $form['lastname'] ?></td>

                      <td><?php echo $form['lastname']->renderError() ?></td>

                  </tr>

                  <tr>

                      <td><?php echo $form['address']->renderLabel() ?></td>

                      <td><?php echo $form['address'] ?></td>

                      <td><?php echo $form['address']->renderError() ?></td>

                  </tr>

                  <tr>

                      <td><?php echo $form['gender']->renderLabel() ?></td>

                      <td><?php echo $form['gender'] ?></td>

                      <td><?php echo $form['gender']->renderError() ?></td>

                  </tr>
				  
				  <tr>

                      <td><?php echo $form['prefferred_language']->renderLabel() ?></td>

                      <td><?php echo $form['prefferred_language'] ?></td>

                      <td><?php echo $form['prefferred_language']->renderError() ?></td>

                  </tr>

				 <tr>

                      <td><?php echo $form['prefferred_currency']->renderLabel() ?></td>

                      <td><?php echo $form['prefferred_currency'] ?></td>

                      <td><?php echo $form['prefferred_currency']->renderError() ?></td>

                  </tr>


                  <tr>

                      <td>

                    <?php echo $form['x_area_id']->renderLabel(); ?>

                    <?php echo $form['x_area_id']?>



                </td>

                      <td class="field">

                            <?php

                  if (sizeof($areas))

                  {

                    foreach($areas as $i => $area)

                    {

                      include_partial('manageProduct/childArea', array('x_areas' => $xarea_table->getChildren($area->getParentId()), 'selected_id' => $area->getId()));

                    }

                  }

                  else

                  {

                      include_partial('manageProduct/childArea', array('x_areas' => $xarea_table->getChildren(0), 'selected_id' => 0));

                  }

                  ?></td>

                      <td><?php echo $form['x_area_id']->renderError() ?></td>

                

                  </tr>

                  <tr style="display:none">

                      <td><?php echo $form['culture']->renderLabel() ?></td>

                      <td><?php echo $form['culture'] ?></td>

                      <td><?php echo $form['culture']->renderError() ?></td>

                  </tr>

              </tbody>

            </table>

          </form>

          </div>

        </div>

      </div>

    <div class="boxFooter"><div></div></div>

<script type="text/javascript">

    $(document).ready(function(){

    FCKeditor.ReplaceAllTextareas('fckeditor');

    onChangeNewsType();

    initSWFupload();

    initFcbkAuto();

  });



  //xarea child element

  function getChildElement(element){

      $(element).nextAll(':select').remove();

      var id = $(element).val();

      var parent= $(element).parent('div')

      $('#user_x_area_id').val(id);



    $.ajax({

      url : "<?php echo url_for("manageProduct/childArea")?>",

      data : { id : id },

      cache : false,

      success : function(data){

          var $response=$(data);

          $('#user_x_area_id').val($response.filter(':select:first').val());

          $('.product_x_area:last').after(data);

      }

    });

  }



</script>