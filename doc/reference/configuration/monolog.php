<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Configuration Reference</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="configuration-reference">
      <span id="index-0"></span><h1>Configuration Reference<a class="headerlink" href="#configuration-reference" title="Permalink to this headline">¶</a></h1>
      <div class="configuration-block jsactive clearfix">
	<ul class="simple" style="height: 904px; ">
	  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre>monolog:
    handlers:

        # Examples:
        syslog:
            type:                stream
            path:                /var/log/symfony.log
            level:               ERROR
            bubble:              false
            formatter:           my_formatter
            processors:
                - some_callable
        main:
            type:                fingerscrossed
            action_level:        WARNING
            buffer_size:         30
            handler:             custom
        custom:
            type:                service
            id:                  my_handler

        # Prototype
        name:
            type:                 ~ # Required
            id:                   ~
            priority:             0
            level:                DEBUG
            bubble:               true
            path:                 %kernel.logs_dir%/%kernel.environment%.log
            ident:                false
            facility:             user
            max_files:            0
            action_level:         WARNING
            stop_buffering:       true
            buffer_size:          0
            handler:              ~
            members:              []
            from_email:           ~
            to_email:             ~
            subject:              ~
            email_prototype:      ~
            formatter:            ~
            processors:           []
    processors:

        # Example:
		- @my_processor</pre>
	    </div>
	  </li>
	  <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><pre>&lt;container xmlns="http://symfony.com/schema/dic/services"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:monolog="http://symfony.com/schema/dic/monolog"
    xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd
                        http://symfony.com/schema/dic/monolog http://symfony.com/schema/dic/monolog/monolog-1.0.xsd"&gt;

    &lt;monolog:config&gt;
        &lt;monolog:handler
            name="syslog"
            type="stream"
            path="/var/log/symfony.log"
            level="error"
            bubble="false"
            formatter="my_formatter"
        &gt;
            &lt;monolog:processor callback="some_callable" /&gt;
        &lt;/monolog:handler /&gt;
        &lt;monolog:handler
            name="main"
            type="fingerscrossed"
            action-level="warning"
            handler="custom"
        /&gt;
        &lt;monolog:handler
            name="custom"
            type="service"
            id="my_handler"
        /&gt;
        &lt;monolog:processor callback="@my_processor" /&gt;
    &lt;/monolog:config&gt;
		&lt;/container&gt;</pre>
	    </div>
	  </li>
	</ul>
      </div>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">When the profiler is enabled, a handler is added to store the logs'
	    messages in the profiler. The profiler uses the name "debug" so it
	    is reserved and cannot be used in the configuration.</p>
      </div></div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="TwigBundle Configuration Reference" href="twig.html">
      «&nbsp;TwigBundle Configuration Reference
    </a><span class="separator">|</span>
    <a accesskey="N" title="WebProfilerBundle Configuration" href="web_profiler.html">
      WebProfilerBundle Configuration&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
