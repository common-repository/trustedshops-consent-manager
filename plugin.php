<?php
/**
 * @package TrustedShopsConsent
 * @version 1.2.2
 * @meta ❤
 * Plugin Name: Trusted Shops Consent-Manager
 * Plugin URI: https://legalservices.trustedshops.de/hilfe-center/consent-manager-jtl
 * Description: Einfache Konfiguration des Trusted Shops Consent-Managers. Plugin entwickelt von: wnm GmbH
 * Version: 1.2.2
 * Author: wnm GmbH
 * Author URI: https://www.walkenewmedia.de/
*/

/**
 * Registers the Actions for this plugin
 */
add_action('wp_head', 'wnmTrustedShopsRegisterProxyMeta');
add_action('admin_menu', 'wnmTrustedShopsRegisterMenuPage');
add_action('wp_enqueue_scripts', 'wnmTrustedShopsRegisterConsentScript');
add_action('wp_enqueue_scripts', 'wnmTrustedShopsRegisterFrontendStyle');
add_action('admin_enqueue_scripts', 'wnmTrustedShopsRegisterAdminStyleAndScripts');

/**
 * Register the Admin Style for the settings page of this plugin
 */
function wnmTrustedShopsRegisterAdminStyleAndScripts() {
    wp_enqueue_style('ts_consent_manager', plugins_url('/styles/admin.css', __FILE__));
    wp_enqueue_script('wnm_news_container', plugins_url('/scripts/rss.global.min.js', __FILE__));
    wp_enqueue_script('wnm_news_script', plugins_url('/scripts/wnm_news_rss.js', __FILE__));
}

/**
 * Outputs the meta tag for the Usercentrics proxy
 */
function wnmTrustedShopsRegisterProxyMeta() {
    ?>
    <meta data-privacy-proxy-server="https://privacy-proxy-server.usercentrics.eu" />
    <?php
}

/**
 * Register the Frontend Style
 */
function wnmTrustedShopsRegisterFrontendStyle() {
    wp_enqueue_style('ts_consent_manager_frontend', plugins_url('/styles/frontend.css', __FILE__));
}


/**
 * Includes the JS files for the Consent-Manager in the header
 */
function wnmTrustedShopsRegisterConsentScript() {
    if(esc_attr(get_option('trustedshops_scriptid'))) {
        // Script-Inject: Smart Data Protector
        if(get_option('trustedshops_smartdataprotector')) {
            wp_print_script_tag(array(
                'src' => 'https://privacy-proxy.usercentrics.eu/latest/uc-block.bundle.js'
            ));
        }
        wp_print_script_tag(array(
            'data-settings-id' => esc_attr( get_option('trustedshops_scriptid') ),
            'src' => 'https://app.usercentrics.eu/browser-ui/latest/loader.js',
            'data-language' => 'de',
            'id' => 'usercentrics-cmp',
            'async'
        ));
    }
}



/**
 * Registers the Settings Page for Wordpress
 */
function wnmTrustedShopsRegisterMenuPage() {
    // Logo in plugin/ressources folder; encoded in base64
    $SVG_Icon = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyNS4yLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iRWJlbmVfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAxNiAxNiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMTYgMTY7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+DQoJLnN0MHtmaWxsOiM5REEzQTg7fQ0KPC9zdHlsZT4NCjxnPg0KCTxnIGlkPSJzaW1wbGlmaWVkLWVfM18iPg0KCQk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNOCwwLjE3QzMuNjgsMC4xNywwLjE3LDMuNjgsMC4xNyw4UzMuNjgsMTUuODMsOCwxNS44M3M3LjgzLTMuNTEsNy44My03LjgzUzEyLjMyLDAuMTcsOCwwLjE3eiBNNy45NCwxMi45MQ0KCQkJQzUuMjEsMTIuOTEsMywxMC43LDMsNy45N2MwLTIuNzIsMi4yMS00LjkzLDQuOTMtNC45M3M0LjkzLDIuMjEsNC45Myw0LjkzQzEyLjg3LDEwLjcsMTAuNjYsMTIuOTEsNy45NCwxMi45MXoiLz4NCgkJPHBhdGggY2xhc3M9InN0MCIgZD0iTTEwLjA4LDkuNTJjLTAuNzIsMS4wNi0xLjcyLDIuMDMtMy4wNiwyLjAzYy0xLjQyLDAtMi4yNS0wLjg5LTIuMjUtMi4zMmMwLTIuMzIsMS43Mi00LjYsNC4xMy00LjYNCgkJCWMwLjgxLDAsMS45LDAuMzMsMS45LDEuMzFjMCwxLjc2LTIuNzYsMi4zNS00LjEyLDIuN0M2LjY1LDguOTMsNi42LDkuMjMsNi42LDkuNTJjMCwwLjYxLDAuMzMsMS4xNywxLDEuMTcNCgkJCWMwLjg3LDAsMS41OC0wLjg0LDIuMDktMS40N0wxMC4wOCw5LjUyeiBNOS4zMyw1LjczYzAtMC4zNi0wLjItMC42NC0wLjU4LTAuNjRjLTEuMTIsMC0xLjcsMi4xOC0xLjkyLDMuMDQNCgkJCUM3Ljg4LDcuODIsOS4zMyw2Ljk3LDkuMzMsNS43M3oiLz4NCgk8L2c+DQo8L2c+DQo8L3N2Zz4NCg==";
	add_menu_page('Trusted Shops', 'Consent-Manager', 'administrator', __FILE__, 'wnmTrustedShopsSettingsPage', $SVG_Icon);
	add_action( 'admin_init', 'wnmTrustedShopsRegisterSettings');
}

/**
 * Registers the Settings Options for persisting storage of the values
 */
function wnmTrustedShopsRegisterSettings() {
	register_setting( 'trustedshops', 'trustedshops_scriptid' ); // Input Text: Script ID
	register_setting( 'trustedshops', 'trustedshops_smartdataprotector' ); // Checkbox: Smart Data Protector
}

/**
 * View of the Settings page
 */
function wnmTrustedShopsSettingsPage() { ?>
<div class="wrap" id="ts_consent_manager">
    <h1>Trusted Shops Consent-Manager</h1>

    <section class="consent_settings">
        <h2>Einstellungen</h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'trustedshops' ); ?>
            <?php do_settings_sections( 'trustedshops' ); ?>

            <table class='ts_consent_settings_table'>
                <tr>
                    <th>
                        Consent-Manager Script-ID
                    </th>
                    <td>
                        <label>
                            <input type="text" name="trustedshops_scriptid" value="<?php echo esc_attr( get_option('trustedshops_scriptid') ); ?>" placeholder="Ihre Script-ID" />
                        </label>
                    </td>
                </tr>
                <tr>
                    <th>
                        Smart Data Protector
                    </th>
                    <td>
                        <label>
                            <input type="checkbox" name="trustedshops_smartdataprotector" value="1" <?php checked(1, get_option('trustedshops_smartdataprotector'), true); ?> />
                        </label>
                        <span style="padding-top: 3px;">Aktivieren</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php submit_button("Einstellungen speichern"); ?>
                    </td>
                    <td>
                        <i>Bitte beachten Sie vor der Aktivierung der Smart-Data-Protector<br />Funktion die Hinweise in unserem <a href='#'>Hilfe-Center</a></i>
                    </td>
                </tr>
            </table>
        </form>
    </section>

    <hr>

    <section class="documentation_notes_reduced">
        <h2>Dokumentation und Support</h2>
        <ul>
            <li>
                <a href="https://experts.etrusted.com/hilfe-center/consent-manager-jtl" class="btn btn-success">Installationsanleitung / Einrichtung</a>
            </li>
            <li>
                <a href="https://www.walkenewmedia.de/kontakt/" class="btn btn-success">Support von wnm&reg; erhalten</a>
            </li>
        </ul>
    </section>

    <section class="wnm_news">
        <h2>News von wnm</h2>
        <div id="rss-feeds">
            <span class="loading">Neuigkeiten werden geladen</span>
        </div>
        <script></script>
    </section>
</div>
<?php } ?>