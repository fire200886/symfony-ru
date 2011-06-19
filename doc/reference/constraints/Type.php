<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Type</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="type">
      <h1>Type<a class="headerlink" href="#type" title="Permalink to this headline">¶</a></h1>
      <p>Validates that a value has a specific data type</p>
      <div class="highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">age</span><span class="p-Indicator">:</span>
        <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Type</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">integer</span>
	</pre></div>
      </div>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">type</span></tt> (<strong>default</strong>, required): A fully qualified class name or one of the
	    PHP datatypes as determined by PHP's <tt class="docutils literal"><span class="pre">is_</span></tt> functions.<ul>
	      <li><a class="reference external" href="http://php.net/is_array">array</a></li>
	      <li><a class="reference external" href="http://php.net/is_bool">bool</a></li>
	      <li><a class="reference external" href="http://php.net/is_callable">callable</a></li>
	      <li><a class="reference external" href="http://php.net/is_float">float</a></li>
	      <li><a class="reference external" href="http://php.net/is_double">double</a></li>
	      <li><a class="reference external" href="http://php.net/is_int">int</a></li>
	      <li><a class="reference external" href="http://php.net/is_integer">integer</a></li>
	      <li><a class="reference external" href="http://php.net/is_long">long</a></li>
	      <li><a class="reference external" href="http://php.net/is_null">null</a></li>
	      <li><a class="reference external" href="http://php.net/is_numeric">numeric</a></li>
	      <li><a class="reference external" href="http://php.net/is_object">object</a></li>
	      <li><a class="reference external" href="http://php.net/is_real">real</a></li>
	      <li><a class="reference external" href="http://php.net/is_resource">resource</a></li>
	      <li><a class="reference external" href="http://php.net/is_scalar">scalar</a></li>
	      <li><a class="reference external" href="http://php.net/is_string">string</a></li>
	    </ul>
	  </li>
	  <li><tt class="docutils literal"><span class="pre">message</span></tt>: The error message in case the validation fails</li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="True" href="True.html">
      «&nbsp;True
    </a><span class="separator">|</span>
    <a accesskey="N" title="Callback" href="Callback.html">
      Callback&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
