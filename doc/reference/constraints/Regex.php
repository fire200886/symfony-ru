<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Regex</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="regex">
      <h1>Regex<a class="headerlink" href="#regex" title="Permalink to this headline">¶</a></h1>
      <p>Validates that a value matches a regular expression.</p>
      <div class="highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">title</span><span class="p-Indicator">:</span>
        <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Regex</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">/\w+/</span>
	</pre></div>
      </div>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">pattern</span></tt> (<strong>default</strong>, required): The regular expression pattern</li>
	  <li><tt class="docutils literal"><span class="pre">match</span></tt>: Whether the pattern must be matched or must not be matched.
	    Default: <tt class="docutils literal"><span class="pre">true</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">message</span></tt>: The error message if validation fails</li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="NotNull" href="NotNull.html">
      «&nbsp;NotNull
    </a><span class="separator">|</span>
    <a accesskey="N" title="Time" href="Time.html">
      Time&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
