<?php include(__DIR__.'/../../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">time Field Type</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="time-field-type">
      <span id="index-0"></span><h1>time Field Type<a class="headerlink" href="#time-field-type" title="Permalink to this headline">¶</a></h1>
      <p>A field to capture time input.</p>
      <p>This can be rendered as a text field or a series of choice fields. The underlying
	data can be stored as a <tt class="docutils literal"><span class="pre">DateTime</span></tt> object, a string, a timestamp or an
	array.</p>
      <table border="1" class="docutils">
	<colgroup>
	  <col width="22%">
	  <col width="78%">
	</colgroup>
	<tbody valign="top">
	  <tr><td>Underlying Data Type</td>
	    <td>can be <tt class="docutils literal"><span class="pre">DateTime</span></tt>, string, timestamp, or array (see the <tt class="docutils literal"><span class="pre">input</span></tt> option)</td>
	  </tr>
	  <tr><td>Rendered as</td>
	    <td>can be various tags (see below)</td>
	  </tr>
	  <tr><td>Options</td>
	    <td><ul class="first last simple">
		<li><tt class="docutils literal"><span class="pre">widget</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">input</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">with_seconds</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">hours</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">minutes</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">seconds</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">data_timezone</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">user_timezone</span></tt></li>
	      </ul>
	    </td>
	  </tr>
	  <tr><td>Parent type</td>
	    <td>form</td>
	  </tr>
	  <tr><td>Class</td>
	    <td><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Form/Extension/Core/Type/TimeType.html" title="Symfony\Component\Form\Extension\Core\Type\TimeType"><span class="pre">TimeType</span></a></tt></td>
	  </tr>
	</tbody>
      </table>
      <div class="section" id="basic-usage">
	<h2>Basic Usage<a class="headerlink" href="#basic-usage" title="Permalink to this headline">¶</a></h2>
	<p>This field type is highly configurable, but easy to use. The most important
	  options are <tt class="docutils literal"><span class="pre">input</span></tt> and <tt class="docutils literal"><span class="pre">widget</span></tt>.</p>
	<p>Suppose that you have a <tt class="docutils literal"><span class="pre">startTime</span></tt> field whose underlying time data is a
	  <tt class="docutils literal"><span class="pre">DateTime</span></tt> object. The following configures the <tt class="docutils literal"><span class="pre">time</span></tt> type for that
	  field as three different choice fields:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'startTime'</span><span class="p">,</span> <span class="s1">'date'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'input'</span>  <span class="o">=&gt;</span> <span class="s1">'datetime'</span><span class="p">,</span>
    <span class="s1">'widget'</span> <span class="o">=&gt;</span> <span class="s1">'choice'</span><span class="p">,</span>
<span class="p">));</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">input</span></tt> option <em>must</em> be changed to match the type of the underlying
	  date data. For example, if the <tt class="docutils literal"><span class="pre">startTime</span></tt> field's data were a unix timestamp,
	  you'd need to set <tt class="docutils literal"><span class="pre">input</span></tt> to <tt class="docutils literal"><span class="pre">timestamp</span></tt>:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'startTime'</span><span class="p">,</span> <span class="s1">'date'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'input'</span>  <span class="o">=&gt;</span> <span class="s1">'datetime'</span><span class="p">,</span>
    <span class="s1">'widget'</span> <span class="o">=&gt;</span> <span class="s1">'choice'</span><span class="p">,</span>
<span class="p">));</span>
	  </pre></div>
	</div>
	<p>The field also supports an <tt class="docutils literal"><span class="pre">array</span></tt> and <tt class="docutils literal"><span class="pre">string</span></tt> as valid <tt class="docutils literal"><span class="pre">input</span></tt> option
	  values.</p>
      </div>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">widget</span></tt> [type: string, default: <tt class="docutils literal"><span class="pre">choice</span></tt>]</dt>
	      <dd><p class="first">Type of widget used for this form type.  Can be <tt class="docutils literal"><span class="pre">text</span></tt> or <tt class="docutils literal"><span class="pre">choice</span></tt>.</p>
		<blockquote class="last">
		  <div><ul class="simple">
		      <li><tt class="docutils literal"><span class="pre">text</span></tt>: renders a single input of type text.  User's input is validated based on the <tt class="docutils literal"><span class="pre">format</span></tt> option.</li>
		      <li><tt class="docutils literal"><span class="pre">choice</span></tt>: renders two select inputs (three select inputs if <tt class="docutils literal"><span class="pre">with_seconds</span></tt> is set to <tt class="docutils literal"><span class="pre">true</span></tt>).</li>
		    </ul>
		</div></blockquote>
	      </dd>
	    </dl>
	  </li>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">input</span></tt> [type: string, default: <tt class="docutils literal"><span class="pre">datetime</span></tt>]</dt>
	      <dd><p class="first">The value of the input for the widget.  Can be <tt class="docutils literal"><span class="pre">string</span></tt>, <tt class="docutils literal"><span class="pre">datetime</span></tt> or <tt class="docutils literal"><span class="pre">array</span></tt>.  The form type input value will be returned
		  in the format specified.  The value "12:30" with the <tt class="docutils literal"><span class="pre">input</span></tt> option set to <tt class="docutils literal"><span class="pre">array</span></tt> would return:</p>
		<div class="last highlight-php"><div class="highlight"><pre><span class="k">array</span><span class="p">(</span><span class="s1">'hour'</span> <span class="o">=&gt;</span> <span class="s1">'12'</span><span class="p">,</span> <span class="s1">'minute'</span> <span class="o">=&gt;</span> <span class="s1">'30'</span> <span class="p">)</span>
		  </pre></div>
		</div>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">with_seconds</span></tt> [type: Boolean, default: false]</dt>
	      <dd><p class="first last">Whether or not to include seconds in the input. This will result in an additional input to capture seconds.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">hours</span></tt> [type: integer, default: 1 to 23 ]</dt>
	      <dd><p class="first last">List of hours available to the hours field type.  This option is only relevant when the <tt class="docutils literal"><span class="pre">widget</span></tt> option is set to <tt class="docutils literal"><span class="pre">choice</span></tt>.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">minutes</span></tt> [type: integer, default: 1 to 59 ]</dt>
	      <dd><p class="first last">List of minutes available to the minutes field type.  This option is only relevant when the <tt class="docutils literal"><span class="pre">widget</span></tt> option is set to <tt class="docutils literal"><span class="pre">choice</span></tt>.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">seconds</span></tt> [type: integer, default: 1 to 59 ]</dt>
	      <dd><p class="first last">List of seconds available to the seconds field type.  This option is only relevant when the <tt class="docutils literal"><span class="pre">widget</span></tt> option is set to <tt class="docutils literal"><span class="pre">choice</span></tt>.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">data_timezone</span></tt> [type: string, default: system default timezone]</dt>
	      <dd><p class="first last">Timezone for the data being stored.  This must be one of the <a class="reference external" href="http://php.net/manual/en/timezones.php">PHP supported timezones</a></p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">user_timezone</span></tt> [type: string, default: system default timezone]</dt>
	      <dd><p class="first last">Timezone for the data being submitted by the user.  This must be one of the <a class="reference external" href="http://php.net/manual/en/timezones.php">PHP supported timezones</a></p>
	      </dd>
	    </dl>
	  </li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="textarea Field Type" href="textarea.html">
      «&nbsp;textarea Field Type
    </a><span class="separator">|</span>
    <a accesskey="N" title="timezone Field Type" href="timezone.html">
      timezone Field Type&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
