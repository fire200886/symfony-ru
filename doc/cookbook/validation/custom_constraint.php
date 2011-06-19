<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to create a Custom Validation Constraint</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-create-a-custom-validation-constraint">
      <span id="index-0"></span><h1>How to create a Custom Validation Constraint<a class="headerlink" href="#how-to-create-a-custom-validation-constraint" title="Permalink to this headline">¶</a></h1>
      <p>You can create a custom constraint by extending the base constraint class,
	<tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Validator/Constraint.html" title="Symfony\Component\Validator\Constraint"><span class="pre">Constraint</span></a></tt>. Options for your
	constraint are represented as public properties on the constraint class. For
	example, the <a class="reference internal" href="../../reference/constraints/Url.html"><em>Url</em></a> constraint includes
	the <tt class="docutils literal"><span class="pre">message</span></tt> and <tt class="docutils literal"><span class="pre">protocols</span></tt> properties:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Symfony\Component\Validator\Constraints</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Url</span> <span class="k">extends</span> <span class="nx">\Symfony\Component\Validator\Constraint</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="nv">$message</span> <span class="o">=</span> <span class="s1">'This value is not a valid URL'</span><span class="p">;</span>
    <span class="k">public</span> <span class="nv">$protocols</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span><span class="s1">'http'</span><span class="p">,</span> <span class="s1">'https'</span><span class="p">,</span> <span class="s1">'ftp'</span><span class="p">,</span> <span class="s1">'ftps'</span><span class="p">);</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <p>As you can see, a constraint class is fairly minimal. The actual validation is
	performed by a another "constraint validator" class. The constraint validator
	class is specified by the constraint's <tt class="docutils literal"><span class="pre">validatedBy()</span></tt> method, which
	includes some simple default logic:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="c1">// in the base Symfony\Component\Validator\Constraint class</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">validatedBy</span><span class="p">()</span>
<span class="p">{</span>
    <span class="k">return</span> <span class="nb">get_class</span><span class="p">(</span><span class="nv">$this</span><span class="p">)</span><span class="o">.</span><span class="s1">'Validator'</span><span class="p">;</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <p>In other words, if you create a custom <tt class="docutils literal"><span class="pre">Constraint</span></tt> (e.g. <tt class="docutils literal"><span class="pre">MyConstraint</span></tt>),
	Symfony2 will automatically look for another class, <tt class="docutils literal"><span class="pre">MyConstraintValidator</span></tt>
	when actually performing the validation.</p>
      <p>The validator class is also simple, and only has one required method: <tt class="docutils literal"><span class="pre">isValid</span></tt>.
	Take the <tt class="docutils literal"><span class="pre">NotBlankValidator</span></tt> as an example:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">class</span> <span class="nc">NotBlankValidator</span> <span class="k">extends</span> <span class="nx">ConstraintValidator</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">isValid</span><span class="p">(</span><span class="nv">$value</span><span class="p">,</span> <span class="nx">Constraint</span> <span class="nv">$constraint</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="k">if</span> <span class="p">(</span><span class="k">null</span> <span class="o">===</span> <span class="nv">$value</span> <span class="o">||</span> <span class="s1">''</span> <span class="o">===</span> <span class="nv">$value</span><span class="p">)</span> <span class="p">{</span>
            <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">setMessage</span><span class="p">(</span><span class="nv">$constraint</span><span class="o">-&gt;</span><span class="na">message</span><span class="p">);</span>

            <span class="k">return</span> <span class="k">false</span><span class="p">;</span>
        <span class="p">}</span>

        <span class="k">return</span> <span class="k">true</span><span class="p">;</span>
    <span class="p">}</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <div class="section" id="constraint-validators-with-dependencies">
	<h2>Constraint Validators with Dependencies<a class="headerlink" href="#constraint-validators-with-dependencies" title="Permalink to this headline">¶</a></h2>
	<p>If your constraint validator has dependencies, such as a database connection,
	  it will need to be configured as a service in the dependency injection
	  container. This service must include the <tt class="docutils literal"><span class="pre">validator.constraint_validator</span></tt>
	  tag and an <tt class="docutils literal"><span class="pre">alias</span></tt> attribute:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 148px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">services</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">validator.unique.your_validator_name</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Fully\Qualified\Validator\Class\Name</span>
        <span class="l-Scalar-Plain">tags</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">name</span><span class="p-Indicator">:</span> <span class="nv">validator.constraint_validator</span><span class="p-Indicator">,</span> <span class="nv">alias</span><span class="p-Indicator">:</span> <span class="nv">alias_name</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"validator.unique.your_validator_name"</span> <span class="na">class=</span><span class="s">"Fully\Qualified\Validator\Class\Name"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;argument</span> <span class="na">type=</span><span class="s">"service"</span> <span class="na">id=</span><span class="s">"doctrine.orm.default_entity_manager"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;tag</span> <span class="na">name=</span><span class="s">"validator.constraint_validator"</span> <span class="na">alias=</span><span class="s">"alias_name"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/service&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$container</span>
    <span class="o">-&gt;</span><span class="na">register</span><span class="p">(</span><span class="s1">'validator.unique.your_validator_name'</span><span class="p">,</span> <span class="s1">'Fully\Qualified\Validator\Class\Name'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">addTag</span><span class="p">(</span><span class="s1">'validator.constraint_validator'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'alias'</span> <span class="o">=&gt;</span> <span class="s1">'alias_name'</span><span class="p">))</span>
<span class="p">;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>Your constraint class may now use this alias to reference the appropriate
	  validator:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">validatedBy</span><span class="p">()</span>
<span class="p">{</span>
    <span class="k">return</span> <span class="s1">'alias_name'</span><span class="p">;</span>
<span class="p">}</span>
	  </pre></div>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to handle File Uploads" href="../form/file_uploads.html">
      «&nbsp;How to handle File Uploads
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to Master and Create new Environments" href="../configuration/environments.html">
      How to Master and Create new Environments&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
