<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="essential-blocks-admin-page-wrapper eb-settings-wrap">

    <form action="">
        <div class="eb-header-bar">
            <div class="eb-header-left">
                <div class="eb-admin-logo-inline">
                    <img src="<?php echo ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/images/eb-logo.svg'; ?>">
                </div>
                <h2 class="title">Essential Blocks Settings</h2>
            </div>
        </div>

        <div class="eb-settings-tabs">
            <ul class="eb-tabs">
                <li><a href="#general" class="active"><img src="<?php echo ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/images/icon-settings.svg'; ?>"><span>General</span></a></li>
                <li><a href="#elements"><img src="<?php echo ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/images/icon-modules.svg'; ?>"><span>Blocks</span></a></li>
            </ul>
            <div id="general" class="eb-settings-tab active">
                <div class="row eb-admin-general-wrapper">
                    <div class="eb-admin-general-inner">
                        <div class="eb-admin-block-wrapper">
                            <?php do_action('eb_licensing_wrapper');?>
                            <div class="eb-admin-block eb-admin-block-docs">
                                <header class="eb-admin-block-header">
                                    <div class="eb-admin-block-header-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 46 46"><defs><style>.cls-1{fill:#1abc9c;}</style></defs><title>Documentation</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><rect class="cls-1" x="15.84" y="17.13" width="14.32" height="1.59"/><rect class="cls-1" x="15.84" y="24.19" width="14.32" height="1.59"/><rect class="cls-1" x="15.84" y="20.66" width="14.32" height="1.59"/><path class="cls-1" d="M23,0A23,23,0,1,0,46,23,23,23,0,0,0,23,0Zm5.47,9.9,4.83,4.4H28.47Zm-2.29,23v3.2H15.49a2.79,2.79,0,0,1-2.79-2.79V12.69A2.79,2.79,0,0,1,15.49,9.9H27.28v5.59h6V27.72H15.84v1.59H29.78v1.94H15.84v1.59H26.19Zm11.29,2.52H33.88V39H31.37V35.42H27.78V32.9h3.59V29.31h2.52V32.9h3.59Z"/></g></g><head xmlns=""/></svg>
                                    </div>
                                    <h4 class="eb-admin-title">Documentation</h4>
                                </header>
                                <div class="eb-admin-block-content">
                                    <p>Get started by spending some time with the documentation to get familiar with Essential
                                        Blocks. Build awesome websites for you or your clients with ease.</p>
                                    <a href="https://essential-blocks.com/docs/" class="button button-primary" target="_blank">Documentation</a>
                                </div>
                            </div>
                            <div class="eb-admin-block eb-admin-block-contribution">
                                <header class="eb-admin-block-header">
                                    <div class="eb-admin-block-header-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 46 45.69"><defs><style>.flexia-icon-bug{fill:#9b59b6;}</style></defs><title>Bugs</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="flexia-icon-bug" d="M18.87,28.37,9.16,38.08A8.66,8.66,0,0,0,14.49,40h4.38a9.55,9.55,0,0,0,2.28-.38v5.14a1,1,0,0,0,1.9,0v-5.9A4.83,4.83,0,0,0,25,37.31l.76-.76a.92.92,0,0,0,0-1.33Z"/><path class="flexia-icon-bug" d="M11.64,21.13c-.19-.19-.57-.38-.76-.19H9c-.38,0-.57,0-.76.38L7.07,23H1.17a1,1,0,1,0,0,1.9H6.31a9.56,9.56,0,0,0-.38,2.28V31.6a8.66,8.66,0,0,0,1.9,5.33l9.71-9.71Z"/><path class="flexia-icon-bug" d="M24.39,14.47c.19.19.38.19.76.19a.7.7,0,0,0,.57-.19.92.92,0,0,0,.38-1.14,11.08,11.08,0,0,1-1-3,.87.87,0,0,0-1-.76H22.3a1,1,0,0,0-.76.38,1.14,1.14,0,0,0-.19.76,2.35,2.35,0,0,0,.76,1.52Z"/><path class="flexia-icon-bug" d="M35.81,28.56h3.43a1,1,0,0,0,0-1.9H33.91L20.77,13.52A5.2,5.2,0,0,1,19.25,9.9V6.66a.9.9,0,0,0-1-1h-.19A13.52,13.52,0,0,0,16.21,3,9.12,9.12,0,0,0,9.54,0a9.71,9.71,0,0,0-5.9,2.09,1.44,1.44,0,0,0-.38.76,1,1,0,0,0,.38.76L9.54,7a5.39,5.39,0,0,1-2.86,4.19l-5.14-3a.85.85,0,0,0-1,0c-.38.19-.57.38-.57.76a8.9,8.9,0,0,0,2.67,7,9.53,9.53,0,0,0,6.85,3,4.1,4.1,0,0,0,2.09-.38L26.87,33.89,37.15,44.17a5.2,5.2,0,0,0,3.62,1.52,5,5,0,0,0,4.95-4.95,5.2,5.2,0,0,0-1.52-3.62Z"/><path class="flexia-icon-bug" d="M34.86,24.75c.19.19.38.19.76.19H36a1,1,0,0,0,.57-1V21.51c0-.38-.38-1-.76-1a7,7,0,0,1-3.43-.76.92.92,0,0,0-1.14.38c-.19.38-.19,1,.19,1.14Z"/><path class="flexia-icon-bug" d="M45.71,9.9c-1.52-1.52-5.14-.38-7,.57L35.81,7.62c.76-2.09,1.9-5.71.57-7a.92.92,0,0,0-1.33,0,.92.92,0,0,0,0,1.33c.38.38,0,2.67-1,5.14L28,8a.87.87,0,0,0-.76,1C26.87,14.28,31.63,19,37.34,19c.38,0,1-.38,1-.76l1-6.09c2.47-1,4.76-1.33,5.14-1A.94.94,0,1,0,45.71,9.9Z"/></g></g><head xmlns=""/></svg>
                                    </div>
                                    <h4 class="eb-admin-title">Contribute to Essential Blocks</h4>
                                </header>
                                <div class="eb-admin-block-content">
                                    <p>You can contribute to make Essential Blocks better reporting bugs, creating issues, pull
                                        requests at <a href="https://github.com/WPDevelopers/essential-blocks" target="_blank">Github.</a></p>
                                    <a href="https://github.com/WPDevelopers/essential-blocks/issues/new" class="button button-primary"
                                        target="_blank">Report a bug</a>
                                </div>
                            </div>
                            <div class="eb-admin-block eb-admin-block-support">
                                <header class="eb-admin-block-header">
                                    <div class="eb-admin-block-header-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32.22 42.58"><defs><style>.flexia-icon-support{fill:#6c75ff;}</style></defs><title>Flexia Support</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="flexia-icon-support" d="M6.36,29.34l1.09-1.09h8l-5.08-9.18-3.76.76a2.64,2.64,0,0,0-2,1.91L.09,36.31a2.64,2.64,0,0,0,2.55,3.31H6.36V29.34Z"/><path class="flexia-icon-support" d="M32.13,36.31,27.67,21.75a2.64,2.64,0,0,0-2.06-1.92l-3.74-.71-5.06,9.13h8.56l1.09,1.09V39.62h3.12a2.64,2.64,0,0,0,2.55-3.31Z"/><polygon class="flexia-icon-support" points="8.54 39.62 8.24 39.62 8.24 39.62 23.98 39.62 23.98 39.62 24.28 39.62 24.28 30.43 8.54 30.43 8.54 39.62"/><rect class="flexia-icon-support" x="4.19" y="40.61" width="23.83" height="1.97"/><path class="flexia-icon-support" d="M7.62,12.65c0,.09.1.22.15.36a3.58,3.58,0,0,0,.68,1.22c1.21,3.94,4.33,6.68,7.64,6.67s6.38-2.77,7.55-6.72A3.61,3.61,0,0,0,24.31,13c.06-.14.11-.27.15-.36a2,2,0,0,0-.33-2.41V10.1C24.12,5.2,23.48,0,16,0S7.92,5,7.94,10.15c0,0,0,.06,0,.09A2,2,0,0,0,7.62,12.65Zm1-1.58h0A.55.55,0,0,0,9,10.83l1.3.2a.28.28,0,0,0,.3-.16L11.39,9a35.31,35.31,0,0,0,7.2,1,7.76,7.76,0,0,0,2.11-.25L21.23,11a.27.27,0,0,0,.25.17h.07l1.51-.43a.56.56,0,0,0,.31.3h0c.23.11.3.6.06,1.09-.06.12-.12.27-.18.43a4.18,4.18,0,0,1-.4.82.55.55,0,0,0-.26.33c-1,3.58-3.68,6.08-6.54,6.09s-5.6-2.48-6.63-6a.55.55,0,0,0-.26-.33,4.3,4.3,0,0,1-.41-.82c-.06-.15-.13-.3-.18-.42C8.37,11.68,8.44,11.19,8.67,11.08Z"/></g></g><head xmlns=""/></svg>
                                    </div>
                                    <h4 class="eb-admin-title">Need Help?</h4>
                                </header>
                                <div class="eb-admin-block-content">
                                    <p>Stuck with something? Get help from live chat or support ticket.</p>
                                    <a href="https://wpdeveloper.com/support" class="button button-primary" target="_blank">Submit a Ticket</a>
                                </div>
                            </div>
                            <div class="eb-admin-block eb-admin-block-community">
                                <header class="eb-admin-block-header">
                                    <div class="eb-admin-block-header-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 46 41.82"><defs><style>.cls-1{fill:#00aeff;}</style></defs><title>Like</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g id="thumb-up"><path class="cls-1" d="M0,41.82H8.36V16.73H0Zm46-23a4.19,4.19,0,0,0-4.18-4.18H28.65L30.74,5V4.39a4.39,4.39,0,0,0-.84-2.3L27.6,0,13.8,13.8a3.51,3.51,0,0,0-1.25,2.93V37.64a4.19,4.19,0,0,0,4.18,4.18H35.55a4.13,4.13,0,0,0,3.76-2.51l6.27-14.85A3.56,3.56,0,0,0,45.79,23V18.82H46Z"/></g></g></g><head xmlns=""/></svg>
                                    </div>
                                    <h4 class="eb-admin-title">Join the Community</h4>
                                </header>
                                <div class="eb-admin-block-content">
                                    <p>Join the Facebook community and discuss with fellow developers and users. Best way to
                                        connect with people and get feedback on your projects.</p>

                                    <a href="http://www.facebook.com/groups/wpdeveloper.net" class="review-flexia button button-primary"
                                        target="_blank">Join Facebook Community</a>
                                </div>
                            </div>
                        </div>
                        <!--admin block-wrapper end-->
                    </div>
                    <div class="eb-admin-sidebar">
                        <div class="eb-sidebar-block">
                            <div class="eb-admin-sidebar-logo">
                                <img src="<?php echo ESSENTIAL_BLOCKS_ADMIN_URL; ?>assets/images/eb-logo.svg">
                            </div>
                            <div class="eb-admin-sidebar-cta">
                                <?php printf(__('<a href="%s" target="_blank">Explore Demos</a>', 'eb'), 'https://essential-blocks.com');?>
                            </div>
                        </div>
                    </div>
                    <!--admin sidebar end-->
                </div>
            </div>
            <div id="elements" class="eb-settings-tab eb-elements-list">
                <div class="row">
                    <div class="col-full">
                        <!-- Content Element Starts -->
                        <!-- Switches Here  -->
                        <div id="admin-root"></div>
                        <!-- Content Element Ends -->
                    </div>
                </div>
            </div>
        </div>

    </form>

</div>