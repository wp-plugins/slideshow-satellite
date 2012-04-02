=== Slideshow Satellite ===
Contributors: C- Pres
Donate link: http://c-pr.es/projects/satellite
Tags: slideshow pro, photographer, galleries, satellite, orbit, zurb, zurb orbit, slideshow gallery, slides, slideshow, image gallery, gallery, slideshow satellite, photography, slideshow orbit
Requires at least: 3.0
Tested up to: 3.2.1
Stable tag: 1.1

Rad photo slideshow. Build the best content displays with Slideshow Satellite's incredible customization capabilities. 

== Description ==
The goal of this slideshow is to create beautiful ways of displaying content in ways that suit the content you are providing.

Either use your current Wordpress Media Galleries or take advantage of the Satellite's own custom gallery manager.

To explore the manual or get the premium edition: http://c-pr.es/projects/satellite/

To embed into a post/page, simply insert <code>[satellit]e</code> into its content with optional <code>post_id</code>, <code>thumbs</code>, <code>exclude</code>, <code>include</code>, <code>caption</code>, and <code>auto</code>  parameters.  Check out the Slideshow Satellite Manual on the plugin details page (linked above) for code examples.

== Installation ==
Installing the WordPress Slideshow Satellite plugin manually is very easy. Simply follow the steps below.

1. In your WP Dashboard goto Plugins and Add New. Then click Upload

1. Upload 'slideshow-satellite.zip', Install & Activate.

1. Configure the settings according to your needs through the 'Satellite' > 'Configuration' menu

1. Add and manage your slides in the 'Satellite' > 'Manage Slides' section (Or just use the built in wordpress gallery)

1. Put `[satellite post_id="X" exclude="" caption="on/off" thumbs="on/off"]` to embed a slideshow with the images of a post into your posts/pages or use `[satellite custom=1]` to embed a slideshow with images in 'Manage Slides'

1. For the most up to date list of options available please goto: http://c-pr.es/projects/satellite and check out the manual

1. Premium Edition: You will download the premium edition from the website directly after paying and setting up your user account

1. Premium Edition: Just make sure the `/pro/` folder is in your /wp-content/plugins/slideshow-satellite/ directory and you're set!

== Frequently Asked Questions ==
= I am having some issues with my plugin, whats a good first look? =
Start with 'Reset to Defaults' on the top of your plugin configuration page.

= How can I display the slideshow in a sidebar as a widget? =
Install the plugin Advanced Text Widget and put the embed code in there. We would suggest using the Premium Edition as you can specify width and height in the embed.

= All the images show up on the page, this ain't no slideshow!!! =
The slideshow isn't loading your JS or CSS most likely! That's because the plugin doesn't know it's being called. It's looking for the `[satellite` reference and not seeing it. `[satellite display=off]` in an area being called by the loop on that page or just going to Advanced Settings and turn 'Shortcode Requirement' to off.

= I'm seeing a non-stop loading icon on the page =
You're most likely dealing with some javascript weirdness. Check using Firebug and ask for help in the forums. Your theme or another plugin might be working improperly with Satellite

= Can I display/embed multiple instances of Slideshow Satellite? =
Yes you can, but you have to have the Premium Edition

= What if I only want captions on some of my pages
Set your default captions to off; for any slideshow you put on your page use `[satellite caption="on"]`

= What if my configuration isn't showing up? =
You're most likely not running PHP5. Talk to your host to upgrade or switch your hosting provider. PHP5 is eleventy years old.

= How do I find the numbers to exclude (or include)? =
Not as easy as it used to be! Go into the Media Library. Choose an image you want to exclude and click on it and notice your address bar: "/wp-admin/media.php?action=edit&attachment_id=353". Therefore, `[satellite exclude=353]`

Premium Questions

= My plugin breaks when I install the premium version =
Many times this has to do with how it was uploaded... Delete all the slideshow-satellite files from your plugins directory (this can be done by clicking 'Delete' from the Plugin Page menu) Then use the Plugin Page -> Add New -> Upload -> to upload the slideshow-satellite.zip file

You may also want to "Reset Configuration" from the Configuration page

== Screenshots ==
1. Slideshow Satellite with bottom thumbnails
2. Slideshow Satellite with "Full Right"

Two should be enough, we don't want to bog down your install with screenshots.

== Changelog ==
= 1.1 = 
* Added Caption Hover!
* Added Random capability
* Toggle Requirement of shortcode to load js and css
* Minor bug fixes including Directory Separator
* Added Premium edition notifier of new versions


= 1.02 =
* Created easy out for tinyMCE bug
* Fixed some minor thumbnail issues
* Cleaned up Config Page
 
= 1.0 =
* Initial Plugin Release using a customized ZURB Orbit javascript slideshow
* Created easy one-click transition from Slideshow Gallery Pro
* Took best ideas in the world, created some more, and added some rad spice.

== Upgrade Notice ==

= 1.0 =
Transitioning from Slideshow Gallery Pro? Notice the top yellow bar to copy your old files over.