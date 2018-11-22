<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<?php if ($_SERVER['HTTP_HOST'] == "www.aileensoul.com") { ?>
<!--script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-6060111582812113",
    enable_page_level_ads: true
  });
</script-->
<script>
	(function (i, s, o, g, r, a, m) {
		i['GoogleAnalyticsObject'] = r;
		i[r] = i[r] || function () {
			(i[r].q = i[r].q || []).push(arguments)
		}, i[r].l = 1 * new Date();
		a = s.createElement(o),
		m = s.getElementsByTagName(o)[0];
		a.async = 1;
		a.src = g;
		m.parentNode.insertBefore(a, m)
	})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
	ga('create', 'UA-91486853-1', 'auto');
	ga('send', 'pageview');
</script>
<meta name="msvalidate.01" content="41CAD663DA32C530223EE3B5338EC79E" />
<?php } ?>
<?php 
$segment_array = $this->uri->segment_array();
if(isset($segment_array) && !empty($segment_array))
{
	$this->load->view('feedback_fixed');
}
?>