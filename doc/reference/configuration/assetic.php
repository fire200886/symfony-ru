<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">
  <div class="box_title">
    <h1 class="title_01">AsseticBundle Configuration Reference</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="asseticbundle-configuration-reference">
      <span id="index-0"></span><h1>AsseticBundle Configuration Reference<a class="headerlink" href="#asseticbundle-configuration-reference" title="Permalink to this headline">¶</a></h1>
      <div class="section" id="full-default-configuration">
	<h2>Full Default Configuration<a class="headerlink" href="#full-default-configuration" title="Permalink to this headline">¶</a></h2>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 760px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre>assetic:
    debug:                true
    use_controller:       true
    read_from:            %kernel.root_dir%/../web
    write_to:             %assetic.read_from%
    java:                 /usr/bin/java
    node:                 /usr/bin/node
    sass:                 /usr/bin/sass
    bundles:

        # Defaults (all currently registered bundles):
        - FrameworkBundle
        - SecurityBundle
        - TwigBundle
        - MonologBundle
        - SwiftmailerBundle
        - DoctrineBundle
        - AsseticBundle
        - ...

    assets:

        # Prototype
        name:
            inputs:               []
            filters:              []
            options:

                # Prototype
                name:                 []
    filters:

        # Prototype
        name:                 []
    twig:
        functions:

            # Prototype
		  name:                 []</pre>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="FrameworkBundle Configuration" href="framework.html">
      «&nbsp;FrameworkBundle Configuration
    </a><span class="separator">|</span>
    <a accesskey="N" title="Configuration Reference" href="doctrine.html">
      Configuration Reference&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
