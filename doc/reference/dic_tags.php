<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">The Dependency Injection Tags</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="the-dependency-injection-tags">
      <h1>The Dependency Injection Tags<a class="headerlink" href="#the-dependency-injection-tags" title="Permalink to this headline">¶</a></h1>
      <p>Tags:</p>
      <ul class="simple">
	<li><tt class="docutils literal"><span class="pre">data_collector</span></tt></li>
	<li><tt class="docutils literal"><span class="pre">kernel.listener</span></tt></li>
	<li><tt class="docutils literal"><span class="pre">templating.helper</span></tt></li>
	<li><tt class="docutils literal"><span class="pre">templating.renderer</span></tt></li>
	<li><tt class="docutils literal"><span class="pre">routing.loader</span></tt></li>
	<li><tt class="docutils literal"><span class="pre">twig.extension</span></tt></li>
      </ul>
      <div class="section" id="enabling-custom-php-template-helpers">
	<h2>Enabling Custom PHP Template Helpers<a class="headerlink" href="#enabling-custom-php-template-helpers" title="Permalink to this headline">¶</a></h2>
	<p>To enable a custom template helper, add it as a regular service in one
	  of your configuration, tag it with <tt class="docutils literal"><span class="pre">templating.helper</span></tt> and define an
	  <tt class="docutils literal"><span class="pre">alias</span></tt> attribute (the helper will be accessible via this alias in the
	  templates):</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 148px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">services</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">templating.helper.your_helper_name</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Fully\Qualified\Helper\Class\Name</span>
        <span class="l-Scalar-Plain">tags</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">name</span><span class="p-Indicator">:</span> <span class="nv">templating.helper</span><span class="p-Indicator">,</span> <span class="nv">alias</span><span class="p-Indicator">:</span> <span class="nv">alias_name</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"templating.helper.your_helper_name"</span> <span class="na">class=</span><span class="s">"Fully\Qualified\Helper\Class\Name"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;tag</span> <span class="na">name=</span><span class="s">"templating.helper"</span> <span class="na">alias=</span><span class="s">"alias_name"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/service&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$container</span>
    <span class="o">-&gt;</span><span class="na">register</span><span class="p">(</span><span class="s1">'templating.helper.your_helper_name'</span><span class="p">,</span> <span class="s1">'Fully\Qualified\Helper\Class\Name'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">addTag</span><span class="p">(</span><span class="s1">'templating.helper'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'alias'</span> <span class="o">=&gt;</span> <span class="s1">'alias_name'</span><span class="p">))</span>
<span class="p">;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="enabling-custom-twig-extensions">
	<h2>Enabling Custom Twig Extensions<a class="headerlink" href="#enabling-custom-twig-extensions" title="Permalink to this headline">¶</a></h2>
	<p>To enable a Twig extension, add it as a regular service in one of your
	  configuration, and tag it with <tt class="docutils literal"><span class="pre">twig.extension</span></tt>:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 148px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">services</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">twig.extension.your_extension_name</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Fully\Qualified\Extension\Class\Name</span>
        <span class="l-Scalar-Plain">tags</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">name</span><span class="p-Indicator">:</span> <span class="nv">twig.extension</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"twig.extension.your_extension_name"</span> <span class="na">class=</span><span class="s">"Fully\Qualified\Extension\Class\Name"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;tag</span> <span class="na">name=</span><span class="s">"twig.extension"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/service&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$container</span>
    <span class="o">-&gt;</span><span class="na">register</span><span class="p">(</span><span class="s1">'twig.extension.your_extension_name'</span><span class="p">,</span> <span class="s1">'Fully\Qualified\Extension\Class\Name'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">addTag</span><span class="p">(</span><span class="s1">'twig.extension'</span><span class="p">)</span>
<span class="p">;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="enabling-custom-listeners">
	<span id="dic-tags-kernel-listener"></span><h2>Enabling Custom Listeners<a class="headerlink" href="#enabling-custom-listeners" title="Permalink to this headline">¶</a></h2>
	<p>To enable a custom listener, add it as a regular service in one of your
	  configuration, and tag it with <tt class="docutils literal"><span class="pre">kernel.listener</span></tt>:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 148px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">services</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">kernel.listener.your_listener_name</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Fully\Qualified\Listener\Class\Name</span>
        <span class="l-Scalar-Plain">tags</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">name</span><span class="p-Indicator">:</span> <span class="nv">kernel.listener</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"kernel.listener.your_listener_name"</span> <span class="na">class=</span><span class="s">"Fully\Qualified\Listener\Class\Name"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;tag</span> <span class="na">name=</span><span class="s">"kernel.listener"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/service&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$container</span>
    <span class="o">-&gt;</span><span class="na">register</span><span class="p">(</span><span class="s1">'kernel.listener.your_listener_name'</span><span class="p">,</span> <span class="s1">'Fully\Qualified\Listener\Class\Name'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">addTag</span><span class="p">(</span><span class="s1">'kernel.listener'</span><span class="p">)</span>
<span class="p">;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="enabling-custom-template-engines">
	<h2>Enabling Custom Template Engines<a class="headerlink" href="#enabling-custom-template-engines" title="Permalink to this headline">¶</a></h2>
	<p>To enable a custom template engine, add it as a regular service in one
	  of your configuration, tag it with <tt class="docutils literal"><span class="pre">templating.engine</span></tt>:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 148px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">services</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">templating.engine.your_engine_name</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Fully\Qualified\Engine\Class\Name</span>
        <span class="l-Scalar-Plain">tags</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">name</span><span class="p-Indicator">:</span> <span class="nv">templating.engine</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"templating.engine.your_engine_name"</span> <span class="na">class=</span><span class="s">"Fully\Qualified\Engine\Class\Name"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;tag</span> <span class="na">name=</span><span class="s">"templating.engine"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/service&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$container</span>
    <span class="o">-&gt;</span><span class="na">register</span><span class="p">(</span><span class="s1">'templating.engine.your_engine_name'</span><span class="p">,</span> <span class="s1">'Fully\Qualified\Engine\Class\Name'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">addTag</span><span class="p">(</span><span class="s1">'templating.engine'</span><span class="p">)</span>
<span class="p">;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="enabling-custom-routing-loaders">
	<h2>Enabling Custom Routing Loaders<a class="headerlink" href="#enabling-custom-routing-loaders" title="Permalink to this headline">¶</a></h2>
	<p>To enable a custom routing loader, add it as a regular service in one
	  of your configuration, and tag it with <tt class="docutils literal"><span class="pre">routing.loader</span></tt>:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 148px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">services</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">routing.loader.your_loader_name</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Fully\Qualified\Loader\Class\Name</span>
        <span class="l-Scalar-Plain">tags</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">name</span><span class="p-Indicator">:</span> <span class="nv">routing.loader</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"routing.loader.your_loader_name"</span> <span class="na">class=</span><span class="s">"Fully\Qualified\Loader\Class\Name"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;tag</span> <span class="na">name=</span><span class="s">"routing.loader"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/service&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$container</span>
    <span class="o">-&gt;</span><span class="na">register</span><span class="p">(</span><span class="s1">'routing.loader.your_loader_name'</span><span class="p">,</span> <span class="s1">'Fully\Qualified\Loader\Class\Name'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">addTag</span><span class="p">(</span><span class="s1">'routing.loader'</span><span class="p">)</span>
<span class="p">;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="using-a-custom-logging-channel-with-monolog">
	<span id="dic-tags-monolog"></span><h2>Using a custom logging channel with Monolog<a class="headerlink" href="#using-a-custom-logging-channel-with-monolog" title="Permalink to this headline">¶</a></h2>
	<p>Monolog allows to share the handlers between several logging channels.
	  The logger service uses the channel <tt class="docutils literal"><span class="pre">app</span></tt> but you can change the
	  channel when injecting the logger in a service.</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 166px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre>services:
    my_service:
        class: Fully\Qualified\Loader\Class\Name
        arguments: [@logger]
        tags:
		  - { name: monolog.logger, channel: acme }</pre>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"my_service"</span> <span class="na">class=</span><span class="s">"Fully\Qualified\Loader\Class\Name"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;argument</span> <span class="na">type=</span><span class="s">"service"</span> <span class="na">id=</span><span class="s">"logger"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;tag</span> <span class="na">name=</span><span class="s">"monolog.logger"</span> <span class="na">channel=</span><span class="s">"acme"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/service&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$definition</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span><span class="s1">'Fully\Qualified\Loader\Class\Name'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'logger'</span><span class="p">));</span>
<span class="nv">$definition</span><span class="o">-&gt;</span><span class="na">addTag</span><span class="p">(</span><span class="s1">'monolog.logger'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'channel'</span> <span class="o">=&gt;</span> <span class="s1">'acme'</span><span class="p">));</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">register</span><span class="p">(</span><span class="s1">'my_service'</span><span class="p">,</span> <span class="nv">$definition</span><span class="p">);;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">This works only when the logger service is a constructor argument,
	      not when it is injected through a setter.</p>
	</div></div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Valid" href="constraints/Valid.html">
      «&nbsp;Valid
    </a><span class="separator">|</span>
    <a accesskey="N" title="YAML" href="YAML.html">
      YAML&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
