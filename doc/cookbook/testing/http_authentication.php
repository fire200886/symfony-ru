<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to simulate HTTP Authentication in a Functional Test</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-simulate-http-authentication-in-a-functional-test">
      <span id="index-0"></span><h1>How to simulate HTTP Authentication in a Functional Test<a class="headerlink" href="#how-to-simulate-http-authentication-in-a-functional-test" title="Permalink to this headline">¶</a></h1>
      <p>If your application needs HTTP authentication, pass the username and password
	as server variables to <tt class="docutils literal"><span class="pre">createClient()</span></tt>:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="nv">$client</span> <span class="o">=</span> <span class="nv">static</span><span class="o">::</span><span class="na">createClient</span><span class="p">(</span><span class="k">array</span><span class="p">(),</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'PHP_AUTH_USER'</span> <span class="o">=&gt;</span> <span class="s1">'username'</span><span class="p">,</span>
    <span class="s1">'PHP_AUTH_PW'</span>   <span class="o">=&gt;</span> <span class="s1">'pa$$word'</span><span class="p">,</span>
<span class="p">));</span>
	</pre></div>
      </div>
      <p>You can also override it on a per request basis:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="nv">$client</span><span class="o">-&gt;</span><span class="na">request</span><span class="p">(</span><span class="s1">'DELETE'</span><span class="p">,</span> <span class="s1">'/post/12'</span><span class="p">,</span> <span class="k">array</span><span class="p">(),</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'PHP_AUTH_USER'</span> <span class="o">=&gt;</span> <span class="s1">'username'</span><span class="p">,</span>
    <span class="s1">'PHP_AUTH_PW'</span>   <span class="o">=&gt;</span> <span class="s1">'pa$$word'</span><span class="p">,</span>
<span class="p">));</span>
	</pre></div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to use Gmail to send Emails" href="../gmail.html">
      «&nbsp;How to use Gmail to send Emails
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to test the Interaction of several Clients" href="insulating_clients.html">
      How to test the Interaction of several Clients&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
