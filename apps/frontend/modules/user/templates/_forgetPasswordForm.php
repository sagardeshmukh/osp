
<?php // use_stylesheets_for_form($form) ?>

<?php // use_javascripts_for_form($form) ?>

    

      <div class="boxContent">

        <div class="boxWrap">

          <div style="padding: 5px;">

          <form action="<?php echo url_for('user/forgotPassword') ?>" method="post">

            <table>

              <tfoot>

                <tr>

                  <td colspan="2">

                    <?php echo $form->renderHiddenFields(false) ?>

                    <input type="submit" value="<?php echo $submit ?>"/>
                  </td>

                </tr>

              </tfoot>

              <tbody>

                  <tr>

                      <td><?php echo $form['username']->renderLabel() ?></td>

                      <td><?php echo $form['username'] ?></td>

                      <td><?php echo $form['username']->renderError() ?></td>

                  </tr>

              </tbody>

            </table>

          </form>

          </div>

        </div>

      </div>

    <div class="boxFooter"><div></div></div>