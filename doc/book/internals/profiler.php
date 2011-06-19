<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Profiler</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="profiler">
      <span id="index-0"></span><h1>Profiler<a class="headerlink" href="#profiler" title="Permalink to this headline">¶</a></h1>
      <p>When enabled, the Symfony2 profiler collects useful information about each
	request made to your application and store them for later analysis. Use the
	profiler in the development environment to help you to debug your code and
	enhance performance; use it in the production environment to explore problems
	after the fact.</p>
      <p>You rarely have to deal with the profiler directly as Symfony2 provides
	visualizer tools like the Web Debug Toolbar and the Web Profiler. If you use
	the Symfony2 Standard Edition, the profiler, the web debug toolbar, and the
	web profiler are all already configured with sensible settings.</p>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">The profiler collects information for all requests (simple requests,
	    redirects, exceptions, Ajax requests, ESI requests; and for all HTTP
	    methods and all formats). It means that for a single URL, you can have
	    several associated profiling data (one per external request/response
	    pair).</p>
      </div></div>
      <div class="section" id="visualizing-profiling-data">
	<span id="index-1"></span><h2>Visualizing Profiling Data<a class="headerlink" href="#visualizing-profiling-data" title="Permalink to this headline">¶</a></h2>
	<div class="section" id="using-the-web-debug-toolbar">
	  <h3>Using the Web Debug Toolbar<a class="headerlink" href="#using-the-web-debug-toolbar" title="Permalink to this headline">¶</a></h3>
	  <p>In the development environment, the web debug toolbar is available at the
	    bottom of all pages. It displays a good summary of the profiling data that
	    gives you instant access to a lot of useful information when something does
	    not work as expected.</p>
	  <p>If the summary provided by the Web Debug Toolbar is not enough, click on the
	    token link (a string made of 13 random characters) to access the Web Profiler.</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">If the token is not clickable, it means that the profiler routes are not
		registered (see below for configuration information).</p>
	  </div></div>
	</div>
	<div class="section" id="analyzing-profiling-data-with-the-web-profiler">
	  <h3>Analyzing Profiling data with the Web Profiler<a class="headerlink" href="#analyzing-profiling-data-with-the-web-profiler" title="Permalink to this headline">¶</a></h3>
	  <p>The Web Profiler is a visualization tool for profiling data that you can use
	    in development to debug your code and enhance performance; but it can also be
	    used to explore problems that occur in production. It exposes all information
	    collected by the profiler in a web interface.</p>
	</div>
      </div>
      <div class="section" id="accessing-the-profiling-information">
	<span id="index-2"></span><h2>Accessing the Profiling information<a class="headerlink" href="#accessing-the-profiling-information" title="Permalink to this headline">¶</a></h2>
	<p>You don't need to use the default visualizer to access the profiling
	  information. But how can you retrieve profiling information for a specific
	  request after the fact? When the profiler stores data about a Request, it also
	  associates a token with it; this token is available in the <tt class="docutils literal"><span class="pre">X-Debug-Token</span></tt>
	  HTTP header of the Response:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$profile</span> <span class="o">=</span> <span class="nv">$container</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'profiler'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">loadProfileFromResponse</span><span class="p">(</span><span class="nv">$response</span><span class="p">);</span>

<span class="nv">$profile</span> <span class="o">=</span> <span class="nv">$container</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'profiler'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">loadProfile</span><span class="p">(</span><span class="nv">$token</span><span class="p">);</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">When the profiler is enabled but not the web debug toolbar, or when you
	      want to get the token for an Ajax request, use a tool like Firebug to get
	      the value of the <tt class="docutils literal"><span class="pre">X-Debug-Token</span></tt> HTTP header.</p>
	</div></div>
	<p>Use the <tt class="docutils literal"><span class="pre">find()</span></tt> method to access tokens based on some criteria:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// get the latest 10 tokens</span>
<span class="nv">$tokens</span> <span class="o">=</span> <span class="nv">$container</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'profiler'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">find</span><span class="p">(</span><span class="s1">''</span><span class="p">,</span> <span class="s1">''</span><span class="p">,</span> <span class="mi">10</span><span class="p">);</span>

<span class="c1">// get the latest 10 tokens for all URL containing /admin/</span>
<span class="nv">$tokens</span> <span class="o">=</span> <span class="nv">$container</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'profiler'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">find</span><span class="p">(</span><span class="s1">''</span><span class="p">,</span> <span class="s1">'/admin/'</span><span class="p">,</span> <span class="mi">10</span><span class="p">);</span>

<span class="c1">// get the latest 10 tokens for local requests</span>
<span class="nv">$tokens</span> <span class="o">=</span> <span class="nv">$container</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'profiler'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">find</span><span class="p">(</span><span class="s1">'127.0.0.1'</span><span class="p">,</span> <span class="s1">''</span><span class="p">,</span> <span class="mi">10</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>If you want to manipulate profiling data on a different machine than the one
	  where the information were generated, use the <tt class="docutils literal"><span class="pre">export()</span></tt> and <tt class="docutils literal"><span class="pre">import()</span></tt>
	  methods:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// on the production machine</span>
<span class="nv">$profile</span> <span class="o">=</span> <span class="nv">$container</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'profiler'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">loadProfile</span><span class="p">(</span><span class="nv">$token</span><span class="p">);</span>
<span class="nv">$data</span> <span class="o">=</span> <span class="nv">$profiler</span><span class="o">-&gt;</span><span class="na">export</span><span class="p">(</span><span class="nv">$profile</span><span class="p">);</span>

<span class="c1">// on the development machine</span>
<span class="nv">$profiler</span><span class="o">-&gt;</span><span class="na">import</span><span class="p">(</span><span class="nv">$data</span><span class="p">);</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="configuration">
	<span id="index-3"></span><h2>Configuration<a class="headerlink" href="#configuration" title="Permalink to this headline">¶</a></h2>
	<p>The default Symfony2 configuration comes with sensible settings for the
	  profiler, the web debug toolbar, and the web profiler. Here is for instance
	  the configuration for the development environment:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 220px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># load the profiler</span>
<span class="l-Scalar-Plain">framework</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">profiler</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">only_exceptions</span><span class="p-Indicator">:</span> <span class="nv">false</span> <span class="p-Indicator">}</span>

<span class="c1"># enable the web profiler</span>
<span class="l-Scalar-Plain">web_profiler</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">toolbar</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">true</span>
    <span class="l-Scalar-Plain">intercept_redirects</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">true</span>
    <span class="l-Scalar-Plain">verbose</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">true</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- xmlns:webprofiler="http://symfony.com/schema/dic/webprofiler" --&gt;</span>
<span class="c">&lt;!-- xsi:schemaLocation="http://symfony.com/schema/dic/webprofiler http://symfony.com/schema/dic/webprofiler/webprofiler-1.0.xsd"&gt; --&gt;</span>

<span class="c">&lt;!-- load the profiler --&gt;</span>
<span class="nt">&lt;framework:config&gt;</span>
    <span class="nt">&lt;framework:profiler</span> <span class="na">only-exceptions=</span><span class="s">"false"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/framework:config&gt;</span>

<span class="c">&lt;!-- enable the web profiler --&gt;</span>
<span class="nt">&lt;webprofiler:config</span>
    <span class="na">toolbar=</span><span class="s">"true"</span>
    <span class="na">intercept-redirects=</span><span class="s">"true"</span>
    <span class="na">verbose=</span><span class="s">"true"</span>
<span class="nt">/&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// load the profiler</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'framework'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'profiler'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'only-exceptions'</span> <span class="o">=&gt;</span> <span class="k">false</span><span class="p">),</span>
<span class="p">));</span>

<span class="c1">// enable the web profiler</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'web_profiler'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'toolbar'</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
    <span class="s1">'intercept-redirects'</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
    <span class="s1">'verbose'</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>When <tt class="docutils literal"><span class="pre">only-exceptions</span></tt> is set to <tt class="docutils literal"><span class="pre">true</span></tt>, the profiler only collects data
	  when an exception is thrown by the application.</p>
	<p>When <tt class="docutils literal"><span class="pre">intercept-redirects</span></tt> is set to <tt class="docutils literal"><span class="pre">true</span></tt>, the web profiler intercepts
	  the redirects and gives you the opportunity to look at the collected data
	  before following the redirect.</p>
	<p>When <tt class="docutils literal"><span class="pre">verbose</span></tt> is set to <tt class="docutils literal"><span class="pre">true</span></tt>, the Web Debug Toolbar displays a lot of
	  information. Setting <tt class="docutils literal"><span class="pre">verbose</span></tt> to <tt class="docutils literal"><span class="pre">false</span></tt> hides some secondary information
	  to make the toolbar shorter.</p>
	<p>If you enable the web profiler, you also need to mount the profiler routes:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 112px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre>_profiler:
    resource: @WebProfilerBundle/Resources/config/routing/profiler.xml
		  prefix:   /_profiler</pre>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;import</span> <span class="na">resource=</span><span class="s">"@WebProfilerBundle/Resources/config/routing/profiler.xml"</span> <span class="na">prefix=</span><span class="s">"/_profiler"</span> <span class="nt">/&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">addCollection</span><span class="p">(</span><span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">import</span><span class="p">(</span><span class="s2">"@WebProfilerBundle/Resources/config/routing/profiler.xml"</span><span class="p">),</span> <span class="s1">'/_profiler'</span><span class="p">);</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>As the profiler adds some overhead, you might want to enable it only under
	  certain circumstances in the production environment. The <tt class="docutils literal"><span class="pre">only-exceptions</span></tt>
	  settings limits profiling to 500 pages, but what if you want to get
	  information when the client IP comes from a specific address, or for a limited
	  portion of the website? You can use a request matcher:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 400px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># enables the profiler only for request coming for the 192.168.0.0 network</span>
<span class="l-Scalar-Plain">framework</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">profiler</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">matcher</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">ip</span><span class="p-Indicator">:</span> <span class="nv">192.168.0.0/24</span> <span class="p-Indicator">}</span>

<span class="c1"># enables the profiler only for the /admin URLs</span>
<span class="l-Scalar-Plain">framework</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">profiler</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">matcher</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">path</span><span class="p-Indicator">:</span> <span class="s">"^/admin/"</span> <span class="p-Indicator">}</span>

<span class="c1"># combine rules</span>
<span class="l-Scalar-Plain">framework</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">profiler</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">matcher</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">ip</span><span class="p-Indicator">:</span> <span class="nv">192.168.0.0/24</span><span class="p-Indicator">,</span> <span class="nv">path</span><span class="p-Indicator">:</span> <span class="s">"^/admin/"</span> <span class="p-Indicator">}</span>

<span class="c1"># use a custom matcher instance defined in the "custom_matcher" service</span>
<span class="l-Scalar-Plain">framework</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">profiler</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">matcher</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">service</span><span class="p-Indicator">:</span> <span class="nv">custom_matcher</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- enables the profiler only for request coming for the 192.168.0.0 network --&gt;</span>
<span class="nt">&lt;framework:config&gt;</span>
    <span class="nt">&lt;framework:profiler&gt;</span>
        <span class="nt">&lt;framework:matcher</span> <span class="na">ip=</span><span class="s">"192.168.0.0/24"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/framework:profiler&gt;</span>
<span class="nt">&lt;/framework:config&gt;</span>

<span class="c">&lt;!-- enables the profiler only for the /admin URLs --&gt;</span>
<span class="nt">&lt;framework:config&gt;</span>
    <span class="nt">&lt;framework:profiler&gt;</span>
        <span class="nt">&lt;framework:matcher</span> <span class="na">path=</span><span class="s">"^/admin/"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/framework:profiler&gt;</span>
<span class="nt">&lt;/framework:config&gt;</span>

<span class="c">&lt;!-- combine rules --&gt;</span>
<span class="nt">&lt;framework:config&gt;</span>
    <span class="nt">&lt;framework:profiler&gt;</span>
        <span class="nt">&lt;framework:matcher</span> <span class="na">ip=</span><span class="s">"192.168.0.0/24"</span> <span class="na">path=</span><span class="s">"^/admin/"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/framework:profiler&gt;</span>
<span class="nt">&lt;/framework:config&gt;</span>

<span class="c">&lt;!-- use a custom matcher instance defined in the "custom_matcher" service --&gt;</span>
<span class="nt">&lt;framework:config&gt;</span>
    <span class="nt">&lt;framework:profiler&gt;</span>
        <span class="nt">&lt;framework:matcher</span> <span class="na">service=</span><span class="s">"custom_matcher"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/framework:profiler&gt;</span>
<span class="nt">&lt;/framework:config&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// enables the profiler only for request coming for the 192.168.0.0 network</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'framework'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'profiler'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'matcher'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'ip'</span> <span class="o">=&gt;</span> <span class="s1">'192.168.0.0/24'</span><span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>

<span class="c1">// enables the profiler only for the /admin URLs</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'framework'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'profiler'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'matcher'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'path'</span> <span class="o">=&gt;</span> <span class="s1">'^/admin/'</span><span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>

<span class="c1">// combine rules</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'framework'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'profiler'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'matcher'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'ip'</span> <span class="o">=&gt;</span> <span class="s1">'192.168.0.0/24'</span><span class="p">,</span> <span class="s1">'path'</span> <span class="o">=&gt;</span> <span class="s1">'^/admin/'</span><span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>

<span class="c1"># use a custom matcher instance defined in the "custom_matcher" service</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'framework'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'profiler'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'matcher'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'service'</span> <span class="o">=&gt;</span> <span class="s1">'custom_matcher'</span><span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="learn-more-from-the-cookbook">
	<h2>Learn more from the Cookbook<a class="headerlink" href="#learn-more-from-the-cookbook" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><a class="reference internal" href="../../cookbook/testing/profiling.html"><em>How to use the Profiler in a Functional Test</em></a></li>
	  <li><a class="reference internal" href="../../cookbook/profiler/data_collector.html"><em>How to create a custom Data Collector</em></a></li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="The Event Dispatcher" href="event_dispatcher.html">
      «&nbsp;The Event Dispatcher
    </a><span class="separator">|</span>
    <a accesskey="N" title="The Symfony2 Stable API" href="../stable_api.html">
      The Symfony2 Stable API&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
