<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">FrameworkBundle Configuration</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="frameworkbundle-configuration">
      <span id="index-0"></span><h1>FrameworkBundle Configuration<a class="headerlink" href="#frameworkbundle-configuration" title="Permalink to this headline">¶</a></h1>
      <p>The <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt> contains most of the "base" framework functionality
	and can be configured under the <tt class="docutils literal"><span class="pre">framework</span></tt> key in your application configuration.
	This includes settings related to sessions, translation, forms, validation,
	routing and more.</p>
      <div class="section" id="full-default-configuration">
	<h2>Full Default Configuration<a class="headerlink" href="#full-default-configuration" title="Permalink to this headline">¶</a></h2>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 1711px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre>framework:

    # general configuration
    charset:              ~
    secret:               ~ # Required
    exception_controller:  Symfony\Bundle\FrameworkBundle\Controller\ExceptionController::showAction
    ide:                  ~
    test:                 ~

    # form configuration
    form:
        enabled:              true
    csrf_protection:
        enabled:              true
        field_name:           _token

    # esi configuration
    esi:
        enabled:              true

    # profiler configuration
    profiler:
        only_exceptions:      false
        only_master_requests:  false
        dsn:                  sqlite:%kernel.cache_dir%/profiler.db
        username:
        password:
        lifetime:             86400
        matcher:
            ip:                   ~
            path:                 ~
            service:              ~

    # router configuration
    router:
        resource:             ~ # Required
        type:                 ~
        http_port:            80
        https_port:           443

    # session configuration
    session:
        auto_start:           ~
        default_locale:       en
        storage_id:           session.storage.native
        name:                 ~
        lifetime:             ~
        path:                 ~
        domain:               ~
        secure:               ~
        httponly:             ~

    # templating configuration
    templating:
        assets_version:       ~
        assets_version_format:  ~
        assets_base_urls:
            http:                 []
            ssl:                  []
        cache:                ~
        engines:              # Required

            # Example:
            - twig
        loaders:              []
        packages:

            # Prototype
            name:
                version:              ~
                version_format:       ~
                base_urls:
                    http:                 []
                    ssl:                  []

    # translator configuration
    translator:
        enabled:              true
        fallback:             en

    # validation configuration
    validation:
        enabled:              true
        cache:                ~
        enable_annotations:   false

    # annotation configuration
    annotations:
        cache:                file
        file_cache_dir:       %kernel.cache_dir%/annotations
		  debug:                true</pre>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="general-configuration">
	<h2>General Configuration<a class="headerlink" href="#general-configuration" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">charset</span></tt> (type: string)</li>
	  <li><tt class="docutils literal"><span class="pre">secret</span></tt> (type: string, <em>required</em>)</li>
	  <li><tt class="docutils literal"><span class="pre">exception_controller</span></tt> (type: string)</li>
	  <li><tt class="docutils literal"><span class="pre">ide</span></tt> (type: string)</li>
	  <li><tt class="docutils literal"><span class="pre">test</span></tt> (type: Boolean)</li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Reference Documents" href="../index.html">
      «&nbsp;Reference Documents
    </a><span class="separator">|</span>
    <a accesskey="N" title="AsseticBundle Configuration Reference" href="assetic.html">
      AsseticBundle Configuration Reference&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
