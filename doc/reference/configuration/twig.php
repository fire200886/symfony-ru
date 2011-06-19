<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">TwigBundle Configuration Reference</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="twigbundle-configuration-reference">
      <span id="index-0"></span><h1>TwigBundle Configuration Reference<a class="headerlink" href="#twigbundle-configuration-reference" title="Permalink to this headline">¶</a></h1>
      <div class="configuration-block jsactive clearfix">
	<ul class="simple" style="height: 544px; ">
	  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre>twig:
    form:
        resources:

            # Default:
            - div_layout.html.twig

            # Example:
            - MyBundle::form.html.twig
    globals:

        # Examples:
        foo:                 "@bar"
        pi:                  3.14

        # Prototype
        key:
            id:                   ~
            type:                 ~
            value:                ~
    autoescape:           ~
    base_template_class:  ~ # Example: Twig_Template
    cache:                %kernel.cache_dir%/twig
    charset:              %kernel.charset%
    debug:                %kernel.debug%
    strict_variables:     ~
		auto_reload:          ~</pre>
	    </div>
	  </li>
	  <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;container</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/dic/services"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xmlns:twig=</span><span class="s">"http://symfony.com/schema/dic/twig"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd</span>
<span class="s">                        http://symfony.com/schema/dic/twig http://symfony.com/schema/dic/doctrine/twig-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;twig:config</span> <span class="na">auto-reload=</span><span class="s">"%kernel.debug%"</span> <span class="na">autoescape=</span><span class="s">"true"</span> <span class="na">base-template-class=</span><span class="s">"Twig_Template"</span> <span class="na">cache=</span><span class="s">"%kernel.cache_dir%/twig"</span> <span class="na">charset=</span><span class="s">"%kernel.charset%"</span> <span class="na">debug=</span><span class="s">"%kernel.debug%"</span> <span class="na">strict-variables=</span><span class="s">"false"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;twig:form&gt;</span>
            <span class="nt">&lt;twig:resource&gt;</span>MyBundle::form.html.twig<span class="nt">&lt;/twig:resource&gt;</span>
        <span class="nt">&lt;/twig:form&gt;</span>
        <span class="nt">&lt;twig:global</span> <span class="na">key=</span><span class="s">"foo"</span> <span class="na">id=</span><span class="s">"bar"</span> <span class="na">type=</span><span class="s">"service"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;twig:global</span> <span class="na">key=</span><span class="s">"pi"</span><span class="nt">&gt;</span>3.14<span class="nt">&lt;/twig:global&gt;</span>
    <span class="nt">&lt;/twig:config&gt;</span>
<span class="nt">&lt;/container&gt;</span>
	      </pre></div>
	    </div>
	  </li>
	  <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'form'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'resources'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'MyBundle::form.html.twig'</span><span class="p">,</span>
        <span class="p">)</span>
     <span class="p">),</span>
     <span class="s1">'globals'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
         <span class="s1">'foo'</span> <span class="o">=&gt;</span> <span class="s1">'@bar'</span><span class="p">,</span>
         <span class="s1">'pi'</span>  <span class="o">=&gt;</span> <span class="mf">3.14</span><span class="p">,</span>
     <span class="p">),</span>
     <span class="s1">'auto_reload'</span>         <span class="o">=&gt;</span> <span class="s1">'%kernel.debug%'</span><span class="p">,</span>
     <span class="s1">'autoescape'</span>          <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
     <span class="s1">'base_template_class'</span> <span class="o">=&gt;</span> <span class="s1">'Twig_Template'</span><span class="p">,</span>
     <span class="s1">'cache'</span>               <span class="o">=&gt;</span> <span class="s1">'%kernel.cache_dir%/twig'</span><span class="p">,</span>
     <span class="s1">'charset'</span>             <span class="o">=&gt;</span> <span class="s1">'%kernel.charset%'</span><span class="p">,</span>
     <span class="s1">'debug'</span>               <span class="o">=&gt;</span> <span class="s1">'%kernel.debug%'</span><span class="p">,</span>
     <span class="s1">'strict_variables'</span>    <span class="o">=&gt;</span> <span class="k">false</span><span class="p">,</span>
<span class="p">));</span>
	      </pre></div>
	    </div>
	  </li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="SwiftmailerBundle Configuration" href="swiftmailer.html">
      «&nbsp;SwiftmailerBundle Configuration
    </a><span class="separator">|</span>
    <a accesskey="N" title="Configuration Reference" href="monolog.html">
      Configuration Reference&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
