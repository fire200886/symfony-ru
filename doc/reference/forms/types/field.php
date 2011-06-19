<?php include(__DIR__.'/../../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">The Abstract "field" Type</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="the-abstract-field-type">
      <span id="index-0"></span><h1>The Abstract "field" Type<a class="headerlink" href="#the-abstract-field-type" title="Permalink to this headline">¶</a></h1>
      <p>The <tt class="docutils literal"><span class="pre">field</span></tt> form type is not an actual field type you use, but rather
	functions as the parent field type for many other fields.</p>
      <p>The <tt class="docutils literal"><span class="pre">field</span></tt> type predefines a couple of options :</p>
      <ul>
	<li><dl class="first docutils">
	    <dt><tt class="docutils literal"><span class="pre">data</span></tt> [type: any, default: the field's initial value]</dt>
	    <dd><p class="first">When you create a form, each field initially displays the value of the
		corresponding property of the form's domain object. If you want to override
		this initial value, you can set it in the data option.</p>
	      <div class="last highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Form\HiddenField</span>

<span class="nv">$field</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">HiddenField</span><span class="p">(</span><span class="s1">'token'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'data'</span> <span class="o">=&gt;</span> <span class="s1">'abcdef'</span><span class="p">,</span>
<span class="p">));</span>

<span class="c1">// renders abcdef</span>
<span class="k">echo</span> <span class="nv">$field</span><span class="o">-&gt;</span><span class="na">getData</span><span class="p">();</span>
		</pre></div>
	      </div>
	    </dd>
	  </dl>
	</li>
      </ul>
      <ul>
	<li><dl class="first docutils">
	    <dt><tt class="docutils literal"><span class="pre">required</span></tt> [type: Boolean, default: true]</dt>
	    <dd><p class="first last">The <tt class="docutils literal"><span class="pre">required</span></tt> option can be used to render an <a class="reference external" href="http://diveintohtml5.org/forms.html">HTML5 required attribute</a>.
		Note that this is independent from validation: if you include the required
		attribute on the field type but omit any required validation, the object
		will appear to be valid to your application with a blank value. In other
		words, this is a <em>nice</em> feature that will add client-side validation for
		browsers that support HTML5. It's not, however, a replacement for true
		server-side validation.</p>
	    </dd>
	  </dl>
	</li>
      </ul>
      <ul>
	<li><dl class="first docutils">
	    <dt><tt class="docutils literal"><span class="pre">disabled</span></tt> [type: Boolean, default: false]</dt>
	    <dd><p class="first">If you don't want a user to modify the value of a field, you can set
		the disabled option to true. Any submitted value will be ignored.</p>
	      <div class="last highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Form\TextField</span>

<span class="nv">$field</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">TextField</span><span class="p">(</span><span class="s1">'status'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'data'</span> <span class="o">=&gt;</span> <span class="s1">'Old data'</span><span class="p">,</span>
    <span class="s1">'disabled'</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
<span class="p">));</span>
<span class="nv">$field</span><span class="o">-&gt;</span><span class="na">submit</span><span class="p">(</span><span class="s1">'New data'</span><span class="p">);</span>

<span class="c1">// prints "Old data"</span>
<span class="k">echo</span> <span class="nv">$field</span><span class="o">-&gt;</span><span class="na">getData</span><span class="p">();</span>
		</pre></div>
	      </div>
	    </dd>
	  </dl>
	</li>
      </ul>
      <ul>
	<li><dl class="first docutils">
	    <dt><tt class="docutils literal"><span class="pre">trim</span></tt> [type: Boolean, default: true]</dt>
	    <dd><p class="first last">If true, the whitespace of the submitted string value will be stripped
		via the <tt class="docutils literal"><span class="pre">trim()</span></tt> function when the data is bound. This guarantees that
		if a value is submitted with extra whitespace, it will be removed before
		the value is merged back onto the underlying object.</p>
	    </dd>
	  </dl>
	</li>
      </ul>
      <ul>
	<li><dl class="first docutils">
	    <dt><tt class="docutils literal"><span class="pre">property_path</span></tt> [type: any, default: the field's value]</dt>
	    <dd><p class="first">Fields display a property value of the form's domain object by default. When
		the form is submitted, the submitted value is written back into the object.</p>
	      <p class="last">If you want to override the property that a field reads from and writes to,
		you can set the <tt class="docutils literal"><span class="pre">property_path</span></tt> option. Its default value is the field's
		name.</p>
	    </dd>
	  </dl>
	</li>
      </ul>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="file Field Type" href="file.html">
      «&nbsp;file Field Type
    </a><span class="separator">|</span>
    <a accesskey="N" title="form Field Type" href="form.html">
      form Field Type&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
