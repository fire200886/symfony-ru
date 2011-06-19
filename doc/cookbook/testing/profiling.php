<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to use the Profiler in a Functional Test</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-use-the-profiler-in-a-functional-test">
      <span id="index-0"></span><h1>How to use the Profiler in a Functional Test<a class="headerlink" href="#how-to-use-the-profiler-in-a-functional-test" title="Permalink to this headline">¶</a></h1>
      <p>It's highly recommended that a functional test only tests the Response. But if
	you write functional tests that monitor your production servers, you might
	want to write tests on the profiling data as it gives you a great way to check
	various things and enforce some metrics.</p>
      <p>The Symfony2 <tt class="xref doc docutils literal"><span class="pre">Profiler</span></tt> gathers a lot of
	data for each request. Use this data to check the number of database calls,
	the time spent in the framework, ... But before writing assertions, always
	check that the profiler is indeed available (it is enabled by default in the
	<tt class="docutils literal"><span class="pre">test</span></tt> environment):</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">class</span> <span class="nc">HelloControllerTest</span> <span class="k">extends</span> <span class="nx">WebTestCase</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">testIndex</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="nv">$client</span> <span class="o">=</span> <span class="nv">static</span><span class="o">::</span><span class="na">createClient</span><span class="p">();</span>
        <span class="nv">$crawler</span> <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">request</span><span class="p">(</span><span class="s1">'GET'</span><span class="p">,</span> <span class="s1">'/hello/Fabien'</span><span class="p">);</span>

        <span class="c1">// Write some assertions about the Response</span>
        <span class="c1">// ...</span>

        <span class="c1">// Check that the profiler is enabled</span>
        <span class="k">if</span> <span class="p">(</span><span class="nv">$profile</span> <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">getProfile</span><span class="p">())</span> <span class="p">{</span>
            <span class="c1">// check the number of requests</span>
            <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertTrue</span><span class="p">(</span><span class="nv">$profile</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'db'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getQueryCount</span><span class="p">()</span> <span class="o">&lt;</span> <span class="mi">10</span><span class="p">);</span>

            <span class="c1">// check the time spent in the framework</span>
            <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertTrue</span><span class="p">(</span> <span class="nv">$profile</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'timer'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getTime</span><span class="p">()</span> <span class="o">&lt;</span> <span class="mf">0.5</span><span class="p">);</span>
        <span class="p">}</span>
    <span class="p">}</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <p>If a test fails because of profiling data (too many DB queries for instance),
	you might want to use the Web Profiler to analyze the request after the tests
	finish. It's easy to achieve if you embed the token in the error message:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertTrue</span><span class="p">(</span>
    <span class="nv">$profile</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'db'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getQueryCount</span><span class="p">()</span> <span class="o">&lt;</span> <span class="mi">30</span><span class="p">,</span>
    <span class="nb">sprintf</span><span class="p">(</span><span class="s1">'Checks that query count is less than 30 (token %s)'</span><span class="p">,</span> <span class="nv">$profile</span><span class="o">-&gt;</span><span class="na">getToken</span><span class="p">())</span>
<span class="p">);</span>
	</pre></div>
      </div>
      <div class="admonition-wrapper">
	<div class="caution"></div><div class="admonition admonition-caution"><p class="first admonition-title">Caution</p>
	  <p class="last">The profiler store can be different depending on the environment
	    (especially if you use the SQLite store, which is the default configured
	    one).</p>
      </div></div>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">The profiler information is available even if you insulate the client or
	    if you use an HTTP layer for your tests.</p>
      </div></div>
      <div class="admonition-wrapper">
	<div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	  <p class="last">Read the API for built-in <a class="reference internal" href="../profiler/data_collector.html"><em>data collectors</em></a>
	    to learn more about their interfaces.</p>
      </div></div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to test the Interaction of several Clients" href="insulating_clients.html">
      «&nbsp;How to test the Interaction of several Clients
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to add &quot;Remember Me&quot; Login Functionality" href="../security/remember_me.html">
      How to add "Remember Me" Login Functionality&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
