<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">File</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="file">
      <h1>File<a class="headerlink" href="#file" title="Permalink to this headline">¶</a></h1>
      <p>Validates that a value is the path to an existing file.</p>
      <div class="highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">filename</span><span class="p-Indicator">:</span>
        <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">File</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
	</pre></div>
      </div>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">maxSize</span></tt>: The maximum allowed file size. Can be provided in bytes, kilobytes
	    (with the suffix "k") or megabytes (with the suffix "M")</li>
	  <li><tt class="docutils literal"><span class="pre">mimeTypes</span></tt>: One or more allowed mime types</li>
	  <li><tt class="docutils literal"><span class="pre">notFoundMessage</span></tt>: The error message if the file was not found</li>
	  <li><tt class="docutils literal"><span class="pre">notReadableMessage</span></tt>: The error message if the file could not be read</li>
	  <li><tt class="docutils literal"><span class="pre">maxSizeMessage</span></tt>: The error message if <tt class="docutils literal"><span class="pre">maxSize</span></tt> validation fails</li>
	  <li><tt class="docutils literal"><span class="pre">mimeTypesMessage</span></tt>: The error message if <tt class="docutils literal"><span class="pre">mimeTypes</span></tt> validation fails</li>
	</ul>
      </div>
      <div class="section" id="example-validating-the-file-size-and-mime-type">
	<h2>Example: Validating the file size and mime type<a class="headerlink" href="#example-validating-the-file-size-and-mime-type" title="Permalink to this headline">¶</a></h2>
	<p>In this example we use the <tt class="docutils literal"><span class="pre">File</span></tt> constraint to verify that the file does
	  not exceed a maximum size of 128 kilobytes and is a PDF document.</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 112px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">filename</span><span class="p-Indicator">:</span>
        <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">File</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">maxSize</span><span class="p-Indicator">:</span> <span class="nv">128k</span><span class="p-Indicator">,</span> <span class="nv">mimeTypes</span><span class="p-Indicator">:</span> <span class="p-Indicator">[</span><span class="nv">application/pdf</span><span class="p-Indicator">,</span> <span class="nv">application/x-pdf</span><span class="p-Indicator">]</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\HelloBundle\Author"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"filename"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"File"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;option</span> <span class="na">name=</span><span class="s">"maxSize"</span><span class="nt">&gt;</span>128k<span class="nt">&lt;/option&gt;</span>
            <span class="nt">&lt;option</span> <span class="na">name=</span><span class="s">"mimeTypes"</span><span class="nt">&gt;</span>
                <span class="nt">&lt;value&gt;</span>application/pdf<span class="nt">&lt;/value&gt;</span>
                <span class="nt">&lt;value&gt;</span>application/x-pdf<span class="nt">&lt;/value&gt;</span>
            <span class="nt">&lt;/option&gt;</span>
        <span class="nt">&lt;/constraint&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
<span class="nt">&lt;/class&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @Assert\File(maxSize = "128k", mimeTypes = {</span>
<span class="sd">     *   "application/pdf",</span>
<span class="sd">     *   "application/x-pdf"</span>
<span class="sd">     * })</span>
<span class="sd">     */</span>
    <span class="k">private</span> <span class="nv">$filename</span><span class="p">;</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Mapping\ClassMetadata</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\File</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">private</span> <span class="nv">$filename</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">loadValidatorMetadata</span><span class="p">(</span><span class="nx">ClassMetadata</span> <span class="nv">$metadata</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'filename'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">File</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
            <span class="s1">'maxSize'</span> <span class="o">=&gt;</span> <span class="s1">'128k'</span><span class="p">,</span>
            <span class="s1">'mimeTypes'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
                <span class="s1">'application/pdf'</span><span class="p">,</span>
                <span class="s1">'application/x-pdf'</span><span class="p">,</span>
            <span class="p">),</span>
        <span class="p">)));</span>
    <span class="p">}</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>When you validate the object with a file that doesn't satisfy one of these
	  constraints, a proper error message is returned by the validator:</p>
	<div class="highlight-text"><div class="highlight"><pre>Acme\HelloBundle\Author.filename:
    The file is too large (150 kB). Allowed maximum size is 128 kB
	  </pre></div>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Email" href="Email.html">
      «&nbsp;Email
    </a><span class="separator">|</span>
    <a accesskey="N" title="Max" href="Max.html">
      Max&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
