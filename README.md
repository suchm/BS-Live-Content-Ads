=== Blueshift Live Content Ads ===

This plugin utilises Blueshift live content to populate Ads on your website based on Blueshift's criteria.

**== Installation ==**

This section describes how to install the plugin and get it working.

1. Upload the Blueshift-Live-Content repo to the `/wp-content/plugins/` directory
2. Activate the plugin through the `Plugins` menu in WordPress
3. Define the following constants in the wp-config.php file (these values can be found in your Blueshift API settings):

```
BSFT_PREFIX:  The prefix of your Blueshift instance.
BSFT_USER_API_KEY:  The Blueshift user API key.
BSFT_EVENT_API_KEY: The Blueshift event API key
```

5. Go the the 'Live Content' post type and select 'Add New'.
6. In the content section include the Ad html and styling that you want to appear on your website.
7. Once the Live Content setup is done in BlueShift include the 'Expiry Date', 'Slot', 'Template' and choose the 'Position'.
8. Hit 'Save Draft' and paste the 'Preview link' into a new browser window to see how the Ad looks.
9. Once happy with the Ad hit publish to make it live. 
