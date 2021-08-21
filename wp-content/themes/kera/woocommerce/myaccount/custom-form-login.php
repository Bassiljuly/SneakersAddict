<?php 

if( !(defined('KERA_WOOCOMMERCE_ACTIVED') && KERA_WOOCOMMERCE_ACTIVED) || is_user_logged_in() ) return;

do_action( 'kera_woocommerce_before_customer_login_form' ); 
?>

<div id="custom-login-wrapper" class="modal fade device-modal-dialog" role="dialog">

    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="top-modal-login">
                <button type="button" class="btn-close" data-dismiss="modal"><i class="zmdi zmdi-close"></i></button>
            </div>
            <div class="modal-body">

                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" class="active" href="#tab-customlogin"><?php esc_html_e('Login', 'kera'); ?></a></li>

                    <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
                    <li><a data-toggle="tab" href="#tab-customregister"><?php esc_html_e('Register', 'kera'); ?></a></li>
                    <?php endif; ?>

                </ul>

                <div class="tab-content clearfix">
                    <div id="tab-customlogin" class="tab-pane fade show active">
                        <form id="custom-login" class="ajax-auth" action="login" method="post">
                            <?php do_action( 'woocommerce_login_form_start' ); ?>

                            <p class="status"></p>  
                            <?php wp_nonce_field('ajax-login-nonce', 'security'); ?>  
                            <input id="cus-username" type="text" placeholder="<?php esc_attr_e('Username/ Email', 'kera'); ?>" class="required form-control" name="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>">
                            <input id="cus-password" type="password" placeholder="<?php esc_attr_e('Password', 'kera'); ?>" class="required form-control" name="password" autocomplete="current-password"> 
                            
                            <div class="rememberme-wrapper">
                                <input name="rememberme" type="checkbox" id="cus-rememberme" value="forever">
                                <label for="cus-rememberme"><?php esc_html_e('Remember me', 'kera'); ?></label>
                            </div>

                            <input class="submit_button" type="submit" value="<?php esc_attr_e('Login', 'kera') ?>">
                            <a id="pop_forgot" class="text-link" href="<?php
                            echo wp_lostpassword_url(); ?>"><?php esc_html_e('Lost password?', 'kera'); ?></a>
                            <div class="clear"></div>
                            <?php do_action( 'woocommerce_login_form_end' ); ?>
                        </form>
                    </div>

                    <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
                    <div id="tab-customregister" class="tab-pane fade">
                        <form id="custom-register" class="ajax-auth"  action="register" method="post">
                            <?php do_action( 'woocommerce_register_form_start' ); ?>

                            <h3><?php esc_html_e('Fill to the forms to create your account', 'kera'); ?></h3>
                            <p class="status"></p>
                            <?php wp_nonce_field('ajax-register-nonce', 'signonsecurity'); ?>         
                            <input id="signonname" type="text" placeholder="<?php esc_attr_e('Username', 'kera'); ?>" name="signonname" class="required form-control" value="<?php echo ( ! empty( $_POST['signonname'] ) ) ? esc_attr( wp_unslash( $_POST['signonname'] ) ) : ''; ?>">
                            <input id="signonemail" type="text" placeholder="<?php esc_attr_e('Email', 'kera'); ?>" class="required email form-control" name="email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>">
                            <input id="signonpassword" type="password" placeholder="<?php esc_attr_e('Password', 'kera'); ?>" class="required form-control" name="signonpassword" autocomplete="new-password">
                            
                            <?php if( kera_tbay_get_config('show_confirm_password', true) ) : ?>
                                <input type="password" id="password2" placeholder="<?php esc_attr_e('Confirm Password', 'kera'); ?>" class="required form-control" name="password2" autocomplete="new-password">
                            <?php endif; ?>
                            
                            <input class="submit_button" type="submit" value="<?php esc_attr_e('Register', 'kera'); ?>">

                            <div class="clear"></div>
                            <?php do_action( 'kera_custom_woocommerce_register_form_end' ); ?>
                            <?php do_action( 'woocommerce_register_form_end' ); ?>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>