<div style="width: 100%">

	<div class="box boxGray" style="width: 52%; float: left">

	  <div class="boxHeader"><div><h3><?php echo __('Register')?></h3></div></div>

	  <div class="boxContent">

	    <div class="boxWrap">



		  <div class="clear"></div>

		  <b  style="margin-top: 10px; margin-bottom: 5px;">Register free with us! Then, you can:</b>

	      <li style="margin-left: 20px;padding-top: 4px;">Save search</li>

	      <li style="margin-left: 20px;padding-top: 6px;">Get new ads by email</li>

              <li style="margin-left: 20px;padding-top: 6px;">Save and share ads</li>

              <li style="margin-left: 20px;padding-top: 6px;">Adding ads</li>

		  <div class="clear"></div>

	    </div>



	  </div>

	  <div class="boxFooter"><div></div></div>

	</div>

	<div class="box boxGray" style="width: 47%;  float: right">

	  <div class="boxHeader"><div><h3 style="width: 480px;"><?php echo __('Login') ?> </h3><div style="float: right"></div></div></div>

	  <div class="boxContent">

	    <div class="boxWrap">

	      <form method="post" id="login_form" action="<?php echo url_for("user/login")?>" onSubmit="$('#login_form').submit(); return false;">

                   <?php echo $form->renderGlobalErrors() ?>

	        <input type="hidden" name="referrer" value="<?php echo $referrer?>" />

			<?php echo $form->renderHiddenFields(false) ?>

			<table cellpadding="5">

              <tbody>

                <tr>

                  <th><?php echo $form["username"]->renderLabel() ?></th>

                  <td>

                   <span> <?php echo $form["username"] ?></span>

                    <span class="desc" style="font-weight: 100;"><?php echo $form["username"]->renderHelp() ?></span><br><?php echo $form["username"]->renderError() ?>

                   </td>

                </tr>

                <tr>

                  <th><?php echo $form["password"]->renderLabel() ?></th>

                  <td>

                    <span><?php echo $form["password"] ?></span>

                    <span class="desc" style="font-weight: 100;"><?php echo $form["password"]->renderHelp() ?></span><br><?php echo $form["password"]->renderError() ?>

                   </td>

                </tr>



                <tr>

                  <th></th>

                  <td>

                    <span style=""><?php echo $form["savepass"] ?></span>

                    <label for="remember_field"><?php echo __('Remember me') ?>.</label> </td>

                </tr>

                <tr>

                  <th></th>

                  <td>

                      <input type="submit" value="Login"/><a href="<?php echo url_for('user/new') ?>"><?php echo __('Register') ?></a>

                  </td>

                </tr>

              </tbody>

			</table>



          </form>

	    </div>



	  </div>

	  <div class="boxFooter"><div></div></div>

	</div>



    <div class="clear"></div>



</div>

<br/>