@extends('mail-log::layout')

@section('content')
    <div class="ui-section-view-main-header">
        <div class="ui-heading">@lang('mail-log::mail.mails')</div>
    </div>

    <div class="ui-section-view-main-body">
        <table class="table ui-table">
            <thead>
                <tr>
                    <th>@lang('mail-log::mail.to')</th>
                    <th>@lang('mail-log::mail.subject')</th>
                    <th>@lang('mail-log::mail.status')</th>
                    <th>@lang('mail-log::mail.reason')</th>
                    <th>@lang('mail-log::mail.sent_at')</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mails as $mail)
                    <tr data-href="{{ route('mail-log::show', $mail) }}">
                        <td>{{ $mail->to }}</td>
                        <td>{{ $mail->subject }}</td>
                        <td>
                            @if ($mail->status == 'delivered')
                                <div class="text-success">{{ $mail->status }}</div>
                            @elseif ($mail->status == 'failed' && $mail->severity == 'temporary')
                                <div class="text-warning">{{ $mail->status }} (temporary)</div>
                            @elseif ($mail->status == 'failed' && $mail->severity == 'permanent')
                                <div class="text-danger">{{ $mail->status }}</div>
                            @else
                                <div class="text-secondary">{{ $mail->status }}</div>
                            @endif
                        </td>
                        <td>{{ $mail->reason }}</td>
                        <td>{{ $mail->created_at->isoFormat('L h:m') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-secondary font-italic" colspan="4">
                            {{ __('mail-log::mail.empty') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $mails->links() }}
        </div>
    </div>
@endsection
