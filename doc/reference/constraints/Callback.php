<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Callback</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="callback">
      <h1>Callback<a class="headerlink" href="#callback" title="Permalink to this headline">¶</a></h1>
      <p>Calls methods during validation on the object. These methods can then perform
	any type of validation and assign errors where needed:</p>
      <div class="highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">Acme\DemoBundle\Entity\Author</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">constraints</span><span class="p-Indicator">:</span>
        <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Callback</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">methods</span><span class="p-Indicator">:</span>   <span class="p-Indicator">[</span><span class="nv">isAuthorValid</span><span class="p-Indicator">]</span>
	</pre></div>
      </div>
      <div class="section" id="usage">
	<h2>Usage<a class="headerlink" href="#usage" title="Permalink to this headline">¶</a></h2>
	<p>The callback method is passed a special <tt class="docutils literal"><span class="pre">ExecutionContext</span></tt> object:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Validator\ExecutionContext</span><span class="p">;</span>

<span class="k">private</span> <span class="nv">$firstName</span><span class="p">;</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">isAuthorValid</span><span class="p">(</span><span class="nx">ExecutionContext</span> <span class="nv">$context</span><span class="p">)</span>
<span class="p">{</span>
    <span class="c1">// somehow you get an array of "fake names"</span>
    <span class="nv">$fakeNames</span> <span class="o">=</span> <span class="k">array</span><span class="p">();</span>

    <span class="c1">// check if the name is actually a fake name</span>
    <span class="k">if</span> <span class="p">(</span><span class="nb">in_array</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">getFirstName</span><span class="p">(),</span> <span class="nv">$fakeNames</span><span class="p">))</span> <span class="p">{</span>
        <span class="nv">$property_path</span> <span class="o">=</span> <span class="nv">$context</span><span class="o">-&gt;</span><span class="na">getPropertyPath</span><span class="p">()</span> <span class="o">.</span> <span class="s1">'.firstName'</span><span class="p">;</span>
        <span class="nv">$context</span><span class="o">-&gt;</span><span class="na">setPropertyPath</span><span class="p">(</span><span class="nv">$property_path</span><span class="p">);</span>
        <span class="nv">$context</span><span class="o">-&gt;</span><span class="na">addViolation</span><span class="p">(</span><span class="s1">'This name sounds totally fake'</span><span class="p">,</span> <span class="k">array</span><span class="p">(),</span> <span class="k">null</span><span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">methods</span></tt>: The method names that should be executed as callbacks.</li>
	  <li><tt class="docutils literal"><span class="pre">message</span></tt>: The error message if the validation fails</li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Type" href="Type.html">
      «&nbsp;Type
    </a><span class="separator">|</span>
    <a accesskey="N" title="Choice" href="Choice.html">
      Choice&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
