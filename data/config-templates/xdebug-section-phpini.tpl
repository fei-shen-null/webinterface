[Zend]
zend_extension_ts = "%PHP_EXT_DIR%php_xdebug.dll"

[XDebug]
; remote debugging
; The URL trigger is ?XDEBUG_SESSION_START= (idekey, see below)
xdebug.idekey=xdebug
xdebug.remote_enable = 1
xdebug.remote_host = localhost
xdebug.remote_port = 9002
xdebug.remote_handler = dbgp
;xdebug.remote_log = "%TEMP_DIR%\xdebug.log"
;xdebug.remote_autostart = 1
; tracer
xdebug.auto_trace = Off
xdebug.collect_params = 4
xdebug.collect_params = Off
xdebug.collect_return = Off
xdebug.trace_output_dir = "%TEMP_DIR%"
; profiler
; The URL trigger is ?XDEBUG_PROFILE
xdebug.profiler_enable_trigger = 0
xdebug.profiler_enable = Off
xdebug.profiler_output_name=cachegrind.out.%s.%t
xdebug.profiler_output_dir = "%TEMP_DIR%"
; output enhancements
xdebug.show_local_vars = 1
; create clickable links, which open editor/ide with file and line highlighting
xdebug.file_link_format = "netbeans://open/?f=%f:%l"

