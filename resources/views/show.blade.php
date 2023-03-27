@extends('mail-log::layout')

@section('content')
    <div class="ui-section-view-main-header">
        <div class="ui-heading">@lang('mail-log::mail.mail')</div>
    </div>

    <div class="ui-section-view-main-body">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{ __('mail-log::mail.status')}}</label>
                    <div class="col-sm-8">
                        <div class="form-control form-control-plaintext">
                            @if ($mail->status == 'delivered')
                                <div class="text-success">{{ $mail->status }}</div>
                            @elseif ($mail->status == 'failed' && $mail->severity == 'temporary')
                                <div class="text-warning">{{ $mail->status }} (temporary)</div>
                            @elseif ($mail->status == 'failed' && $mail->severity == 'permanent')
                                <div class="text-danger">{{ $mail->status }}</div>
                            @else
                                <div class="text-secondary">{{ $mail->status }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{ __('mail-log::mail.reason')}}</label>

                    <div class="col-sm-8">
                        <div class="form-control form-control-plaintext">{{ $mail->reason }}</div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{ __('mail-log::mail.description')}}</label>

                    <div class="col-sm-8">
                        <div class="form-control form-control-plaintext">{{ $mail->description }}</div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{ __('mail-log::mail.message')}}</label>

                    <div class="col-sm-8">
                        <div class="form-control form-control-plaintext">{{ $mail->message }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{ __('mail-log::mail.subject')}}</label>

                    <div class="col-sm-8">
                        <div class="form-control form-control-plaintext">{{ $mail->subject }}</div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{ __('mail-log::mail.to')}}</label>

                    <div class="col-sm-8">
                        <div class="form-control form-control-plaintext">{{ $mail->to }}</div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{ __('mail-log::mail.from')}}</label>

                    <div class="col-sm-8">
                        <div class="form-control form-control-plaintext">{{ $mail->from }}</div>
                    </div>
                </div>

                @if ($mail->cc)
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('mail-log::mail.cc')}}</label>

                        <div class="col-sm-8">
                            <div class="form-control form-control-plaintext">{{ $mail->cc }}</div>
                        </div>
                    </div>
                @endif

                @if ($mail->bcc)
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('mail-log::mail.bcc')}}</label>

                        <div class="col-sm-8">
                            <div class="form-control form-control-plaintext">{{ $mail->bcc }}</div>
                        </div>
                    </div>
                @endif

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{ __('mail-log::mail.body')}}</label>

                    <div class="col-sm-8">
                        <iframe id="iframe" style="width: 100%; height: 700px;" frameborder="0"></iframe>

                        <script type="text/javascript">
                            var doc = document.getElementById('iframe').contentWindow.document;
                            doc.open();
                            doc.write(`{!! $mail->body !!}`);
                            doc.close();
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
