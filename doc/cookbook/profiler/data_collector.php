<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to create a custom Data Collector</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-create-a-custom-data-collector">
      <span id="index-0"></span><h1>How to create a custom Data Collector<a class="headerlink" href="#how-to-create-a-custom-data-collector" title="Permalink to this headline">¶</a></h1>
      <p>The Symfony2 <tt class="xref doc docutils literal"><span class="pre">Profiler</span></tt> delegates data
	collecting to data collectors. Symfony2 comes bundled with a few of them, but
	you can easily create your own.</p>
      <div class="section" id="creating-a-custom-data-collector">
	<h2>Creating a Custom Data Collector<a class="headerlink" href="#creating-a-custom-data-collector" title="Permalink to this headline">¶</a></h2>
	<p>Creating a custom data collector is as simple as implementing the
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/DataCollector/DataCollectorInterface.html" title="Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface"><span class="pre">DataCollectorInterface</span></a></tt>:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">interface</span> <span class="nx">DataCollectorInterface</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * Collects data for the given Request and Response.</span>
<span class="sd">     *</span>
<span class="sd">     * @param Request    $request   A Request instance</span>
<span class="sd">     * @param Response   $response  A Response instance</span>
<span class="sd">     * @param \Exception $exception An Exception instance</span>
<span class="sd">     */</span>
    <span class="k">function</span> <span class="nf">collect</span><span class="p">(</span><span class="nx">Request</span> <span class="nv">$request</span><span class="p">,</span> <span class="nx">Response</span> <span class="nv">$response</span><span class="p">,</span> <span class="nx">\Exception</span> <span class="nv">$exception</span> <span class="o">=</span> <span class="k">null</span><span class="p">);</span>

    <span class="sd">/**</span>
<span class="sd">     * Returns the name of the collector.</span>
<span class="sd">     *</span>
<span class="sd">     * @return string The collector name</span>
<span class="sd">     */</span>
    <span class="k">function</span> <span class="nf">getName</span><span class="p">();</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">getName()</span></tt> method must return a unique name. This is used to access the
	  information later on (see the section about functional tests above for
	  instance).</p>
	<p>The <tt class="docutils literal"><span class="pre">collect()</span></tt> method is responsible for storing the data it wants to give
	  access to in local properties.</p>
	<div class="admonition-wrapper">
	  <div class="caution"></div><div class="admonition admonition-caution"><p class="first admonition-title">Caution</p>
	    <p class="last">As the profiler serializes data collector instances, you should not
	      store objects that cannot be serialized (like PDO objects), or you need
	      to provide your own <tt class="docutils literal"><span class="pre">serialize()</span></tt> method.</p>
	</div></div>
	<p>Most of the time, it is convenient to extend
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/DataCollector/DataCollector.html" title="Symfony\Component\HttpKernel\DataCollector\DataCollector"><span class="pre">DataCollector</span></a></tt> and
	  populate the <tt class="docutils literal"><span class="pre">$this-&gt;data</span></tt> property (it takes care of serializing the
	  <tt class="docutils literal"><span class="pre">$this-&gt;data</span></tt> property):</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">class</span> <span class="nc">MemoryDataCollector</span> <span class="k">extends</span> <span class="nx">DataCollector</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">collect</span><span class="p">(</span><span class="nx">Request</span> <span class="nv">$request</span><span class="p">,</span> <span class="nx">Response</span> <span class="nv">$response</span><span class="p">,</span> <span class="nx">\Exception</span> <span class="nv">$exception</span> <span class="o">=</span> <span class="k">null</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">data</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'memory'</span> <span class="o">=&gt;</span> <span class="nx">memory_get_peak_usage</span><span class="p">(</span><span class="k">true</span><span class="p">),</span>
        <span class="p">);</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getMemory</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">data</span><span class="p">[</span><span class="s1">'memory'</span><span class="p">];</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getName</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="s1">'memory'</span><span class="p">;</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="enabling-custom-data-collectors">
	<span id="data-collector-tag"></span><h2>Enabling Custom Data Collectors<a class="headerlink" href="#enabling-custom-data-collectors" title="Permalink to this headline">¶</a></h2>
	<p>To enable a data collector, add it as a regular service in one of your
	  configuration, and tag it with <tt class="docutils literal"><span class="pre">data_collector</span></tt>:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 148px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">services</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">data_collector.your_collector_name</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Fully\Qualified\Collector\Class\Name</span>
        <span class="l-Scalar-Plain">tags</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">name</span><span class="p-Indicator">:</span> <span class="nv">data_collector</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"data_collector.your_collector_name"</span> <span class="na">class=</span><span class="s">"Fully\Qualified\Collector\Class\Name"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;tag</span> <span class="na">name=</span><span class="s">"data_collector"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/service&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$container</span>
    <span class="o">-&gt;</span><span class="na">register</span><span class="p">(</span><span class="s1">'data_collector.your_collector_name'</span><span class="p">,</span> <span class="s1">'Fully\Qualified\Collector\Class\Name'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">addTag</span><span class="p">(</span><span class="s1">'data_collector'</span><span class="p">)</span>
<span class="p">;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="adding-web-profiler-templates">
	<h2>Adding Web Profiler Templates<a class="headerlink" href="#adding-web-profiler-templates" title="Permalink to this headline">¶</a></h2>
	<p>When you want to display the data collected by your Data Collector in the web
	  debug toolbar or the web profiler, create a Twig template following this
	  skeleton:</p>
	<div class="highlight-jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">extends</span> <span class="s1">'WebProfilerBundle:Profiler:layout.html.twig'</span> <span class="cp">%}</span><span class="x"></span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">toolbar</span> <span class="cp">%}</span><span class="x"></span>
<span class="x">    </span><span class="c">{# the web debug toolbar content #}</span><span class="x"></span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span><span class="x"></span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">head</span> <span class="cp">%}</span><span class="x"></span>
<span class="x">    </span><span class="c">{# if the web profiler panel needs some specific JS or CSS files #}</span><span class="x"></span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span><span class="x"></span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">menu</span> <span class="cp">%}</span><span class="x"></span>
<span class="x">    </span><span class="c">{# the menu content #}</span><span class="x"></span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span><span class="x"></span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">panel</span> <span class="cp">%}</span><span class="x"></span>
<span class="x">    </span><span class="c">{# the panel content #}</span><span class="x"></span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span><span class="x"></span>
	  </pre></div>
	</div>
	<p>Each block is optional. The <tt class="docutils literal"><span class="pre">toolbar</span></tt> block is used for the web debug
	  toolbar and <tt class="docutils literal"><span class="pre">menu</span></tt> and <tt class="docutils literal"><span class="pre">panel</span></tt> are used to add a panel to the web
	  profiler.</p>
	<p>All blocks have access to the <tt class="docutils literal"><span class="pre">collector</span></tt> object.</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">Built-in templates use a base64 encoded image for the toolbar (<tt class="docutils literal"><span class="pre">&lt;img</span>
		<span class="pre">src="src="data:image/png;base64,..."</span></tt>). You can easily calculate the
	      base64 value for an image with this little script: <tt class="docutils literal"><span class="pre">echo</span>
		<span class="pre">base64_encode(file_get_contents($_SERVER['argv'][1]));</span></tt>.</p>
	</div></div>
	<p>To enable the template, add a <tt class="docutils literal"><span class="pre">template</span></tt> attribute to the <tt class="docutils literal"><span class="pre">data_collector</span></tt>
	  tag in your configuration. For example, assuming your template is in some
	  <tt class="docutils literal"><span class="pre">AcmeDebugBundle</span></tt>:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 163px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">services</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">data_collector.your_collector_name</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Acme\DebugBundle\Collector\Class\Name</span>
        <span class="l-Scalar-Plain">tags</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">name</span><span class="p-Indicator">:</span> <span class="nv">data_collector</span><span class="p-Indicator">,</span> <span class="nv">template</span><span class="p-Indicator">:</span> <span class="s">"AcmeDebug:Collector:templatename"</span><span class="p-Indicator">,</span> <span class="nv">id</span><span class="p-Indicator">:</span> <span class="s">"your_collector_name"</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"data_collector.your_collector_name"</span> <span class="na">class=</span><span class="s">"Acme\DebugBundle\Collector\Class\Name"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;tag</span> <span class="na">name=</span><span class="s">"data_collector"</span> <span class="na">template=</span><span class="s">"AcmeDebug:Collector:templatename"</span> <span class="na">id=</span><span class="s">"your_collector_name"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/service&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$container</span>
    <span class="o">-&gt;</span><span class="na">register</span><span class="p">(</span><span class="s1">'data_collector.your_collector_name'</span><span class="p">,</span> <span class="s1">'Acme\DebugBundle\Collector\Class\Name'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">addTag</span><span class="p">(</span><span class="s1">'data_collector'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'template'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeDebugBundle:Collector:templatename'</span><span class="p">,</span> <span class="s1">'id'</span> <span class="o">=&gt;</span> <span class="s1">'your_collector_name'</span><span class="p">))</span>
<span class="p">;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to register a new Request Format and Mime Type" href="../request/mime_type.html">
      «&nbsp;How to register a new Request Format and Mime Type
    </a><span class="separator">|</span>
    <a accesskey="N" title="How Symfony2 differs from symfony1" href="../symfony1.html">
      How Symfony2 differs from symfony1&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
