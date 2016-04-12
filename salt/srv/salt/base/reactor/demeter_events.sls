test_out:
  local.cmd.run:
    - tgt: 'uuid:{{ data['data']['vm'] }}'
    - expr_form: grain
    - arg:
      - touch /tmp/demeter_touch
