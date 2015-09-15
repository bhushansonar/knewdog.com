    <!-- Your Sitemap -->   
<?php  header("Content-Type: text/xml;charset=UTF-8");?>
<?php '<?xml version="1.0" encoding="UTF-8" ?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><url><loc><?php echo base_url();?></loc>
        <priority>1.0</priority>
    </url>
<url>
  <loc>https://www.knewdog.com/signup</loc>
  <priority>0.80</priority>
</url>
<url>
  <loc>https://www.knewdog.com/newsletter</loc>
  <priority>0.80</priority>
</url>
<url>
  <loc>https://www.knewdog.com/blog</loc>
  <priority>0.80</priority>
</url>
<url>
  <loc>https://www.knewdog.com/help</loc>
  
  <priority>0.80</priority>
</url>
<url>
  <loc>https://www.knewdog.com/signup/</loc>
  
  <priority>0.80</priority>
</url>
<url>
  <loc>https://www.knewdog.com/about</loc>
  
  <priority>0.80</priority>
</url>
<url>
  <loc>https://www.knewdog.com/contactus</loc>
  
  <priority>0.80</priority>
</url>
<url>
  <loc>https://www.knewdog.com/help/</loc>
  
  <priority>0.80</priority>
</url>
<url>
  <loc>https://www.knewdog.com/help/gettingstarted</loc>
  
  <priority>0.80</priority>
</url>
<url>
  <loc>https://www.knewdog.com/help/faq</loc>
  
  <priority>0.80</priority>
</url>
<url>
  <loc>https://www.knewdog.com/legal</loc>
  
  <priority>0.80</priority>
</url>
<url>
  <loc>https://www.knewdog.com/signin/forgot_password</loc>
  
  <priority>0.80</priority>
</url>
<url>
  <loc>https://www.knewdog.com/home</loc>
  
  <priority>0.80</priority>
</url>
<url>
  <loc>https://www.knewdog.com/newsletter/2</loc>
  
  <priority>0.64</priority>
</url>
<url>
  <loc>https://www.knewdog.com/blog/specific/some-words-about-our-newsletter-library/4</loc>
  
  <priority>0.64</priority>
</url>
<url>
  <loc>https://www.knewdog.com/blog/specific/how-to-reduce-noise/1</loc>
  
  <priority>0.64</priority>
</url>
<url>
  <loc>https://www.knewdog.com/blog/specific/knewdog-reaches-its-first-milestone-of-100-registered-users-and-starts-further-development/7</loc>
  
  <priority>0.64</priority>
</url>
<url>
  <loc>https://www.knewdog.com/blog/specific/why-did-we-launch-knewdog/3</loc>
  
  <priority>0.64</priority>
</url>
<url>
  <loc>https://www.knewdog.com/contact</loc>
  
  <priority>0.64</priority>
</url>
<url>
  <loc>https://www.knewdog.com/help/gettingstarted/</loc>
  
  <priority>0.64</priority>
</url>
<url>
  <loc>https://www.knewdog.com/help/faq/</loc>
  
  <priority>0.64</priority>
</url>
<url>
  <loc>https://www.knewdog.com/contact/</loc>
  <priority>0.64</priority>
</url>
<url>
  <loc>https://www.knewdog.com/blog/</loc>
  <priority>0.64</priority>
</url>
<url>
  <loc>https://www.knewdog.com/privacy</loc>
  <priority>0.64</priority>
</url>
<url>
  <loc>https://www.knewdog.com/newsletter/1</loc>
  <priority>0.51</priority>
</url>
<url>
  <loc>https://www.knewdog.com/newsletter/</loc>
  <priority>0.51</priority>
</url>
<url>
  <loc>https://www.knewdog.com/preneur-marketing/</loc>
  <priority>0.51</priority>
</url>
<url>
  <loc>https://www.knewdog.com/home/about/</loc>
  <priority>0.51</priority>
</url>
  <?php for($i=0;$i<count($blog);$i++){ ?>
<url>
	<loc><?php echo site_url('blog/specific')."/".url_title($blog[$i]['title_en'],'dash',true)."/".$blog[$i]['blog_id']?></loc>
    <priority>0.5</priority>
</url>
<?php } ?>
  <?php for($i=0;$i<count($newsletter);$i++){ ?>
<url>
	<loc><?php echo site_url('newsletter/specific') . "/" . url_title($newsletter[$i]['newsletter_name'], 'dash', true) . "/" . $newsletter[$i]['newsletter_id']?></loc>
    <priority>0.5</priority>
</url>
<?php } ?> 
</urlset>