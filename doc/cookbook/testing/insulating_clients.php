<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to test the Interaction of several Clients</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-test-the-interaction-of-several-clients">
      <span id="index-0"></span><h1>How to test the Interaction of several Clients<a class="headerlink" href="#how-to-test-the-interaction-of-several-clients" title="Permalink to this headline">¶</a></h1>
      <p>If you need to simulate an interaction between different Clients (think of a
	chat for instance), create several Clients:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="nv">$harry</span> <span class="o">=</span> <span class="nv">static</span><span class="o">::</span><span class="na">createClient</span><span class="p">();</span>
<span class="nv">$sally</span> <span class="o">=</span> <span class="nv">static</span><span class="o">::</span><span class="na">createClient</span><span class="p">();</span>

<span class="nv">$harry</span><span class="o">-&gt;</span><span class="na">request</span><span class="p">(</span><span class="s1">'POST'</span><span class="p">,</span> <span class="s1">'/say/sally/Hello'</span><span class="p">);</span>
<span class="nv">$sally</span><span class="o">-&gt;</span><span class="na">request</span><span class="p">(</span><span class="s1">'GET'</span><span class="p">,</span> <span class="s1">'/messages'</span><span class="p">);</span>

<span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertEquals</span><span class="p">(</span><span class="mi">201</span><span class="p">,</span> <span class="nv">$harry</span><span class="o">-&gt;</span><span class="na">getResponse</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">getStatusCode</span><span class="p">());</span>
<span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertRegExp</span><span class="p">(</span><span class="s1">'/Hello/'</span><span class="p">,</span> <span class="nv">$sally</span><span class="o">-&gt;</span><span class="na">getResponse</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">getContent</span><span class="p">());</span>
	</pre></div>
      </div>
      <p>This works except when your code maintains a global state or if it depends on
	third-party libraries that has some kind of global state. In such a case, you
	can insulate your clients:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="nv">$harry</span> <span class="o">=</span> <span class="nv">static</span><span class="o">::</span><span class="na">createClient</span><span class="p">();</span>
<span class="nv">$sally</span> <span class="o">=</span> <span class="nv">static</span><span class="o">::</span><span class="na">createClient</span><span class="p">();</span>

<span class="nv">$harry</span><span class="o">-&gt;</span><span class="na">insulate</span><span class="p">();</span>
<span class="nv">$sally</span><span class="o">-&gt;</span><span class="na">insulate</span><span class="p">();</span>

<span class="nv">$harry</span><span class="o">-&gt;</span><span class="na">request</span><span class="p">(</span><span class="s1">'POST'</span><span class="p">,</span> <span class="s1">'/say/sally/Hello'</span><span class="p">);</span>
<span class="nv">$sally</span><span class="o">-&gt;</span><span class="na">request</span><span class="p">(</span><span class="s1">'GET'</span><span class="p">,</span> <span class="s1">'/messages'</span><span class="p">);</span>

<span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertEquals</span><span class="p">(</span><span class="mi">201</span><span class="p">,</span> <span class="nv">$harry</span><span class="o">-&gt;</span><span class="na">getResponse</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">getStatusCode</span><span class="p">());</span>
<span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertRegExp</span><span class="p">(</span><span class="s1">'/Hello/'</span><span class="p">,</span> <span class="nv">$sally</span><span class="o">-&gt;</span><span class="na">getResponse</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">getContent</span><span class="p">());</span>
	</pre></div>
      </div>
      <p>Insulated clients transparently execute their requests in a dedicated and
	clean PHP process, thus avoiding any side-effects.</p>
      <div class="admonition-wrapper">
	<div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	  <p class="last">As an insulated client is slower, you can keep one client in the main
	    process, and insulate the other ones.</p>
      </div></div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to simulate HTTP Authentication in a Functional Test" href="http_authentication.html">
      «&nbsp;How to simulate HTTP Authentication in a Functional Test
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to use the Profiler in a Functional Test" href="profiling.html">
      How to use the Profiler in a Functional Test&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
