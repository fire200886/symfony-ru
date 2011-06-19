<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">SwiftmailerBundle Configuration</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="swiftmailerbundle-configuration">
      <span id="index-0"></span><h1>SwiftmailerBundle Configuration<a class="headerlink" href="#swiftmailerbundle-configuration" title="Permalink to this headline">¶</a></h1>
      <div class="section" id="full-default-configuration">
	<h2>Full Default Configuration<a class="headerlink" href="#full-default-configuration" title="Permalink to this headline">¶</a></h2>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 382px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre>swiftmailer:
    transport:            smtp
    username:             ~
    password:             ~
    host:                 localhost
    port:                 false
    encryption:           ~
    auth_mode:            ~
    spool:
        type:                 file
        path:                 %kernel.cache_dir%/swiftmailer/spool
    sender_address:       ~
    antiflood:
        threshold:            99
        sleep:                0
    delivery_address:     ~
    disable_delivery:     ~
		  logging:              true</pre>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Security Configuration Reference" href="security.html">
      «&nbsp;Security Configuration Reference
    </a><span class="separator">|</span>
    <a accesskey="N" title="TwigBundle Configuration Reference" href="twig.html">
      TwigBundle Configuration Reference&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
