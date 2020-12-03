@component('mail::message')
# Please pay commissions for {{ $commissionsInfo['now']->monthName }} {{ $commissionsInfo['now']->year }}

<b>Your profit: </b><span>{{ number_format($commissionsInfo['monthProfit']) }} {{ config('setting.currency_unit') }}</span><br>
<b>Commissions you need to pay: </b><span>{{ number_format($commissionsInfo['commissions']) }} {{ config('setting.currency_unit') }}</span>

@component('mail::panel')
    <div class="method">
        <h3>VIA BANK ACCOUNT:</h3>
        <div class="method-info">
            <p>
                <b>Bank name: </b>
                <span>{{ config('setting.bank_name') }}</span>
            </p>
            <p>
                <b>Owner: </b>
                <span>{{ config('setting.bank_account_owner') }}</span>
            </p>
            <p>
                <b>Branch: </b>
                <span>{{ config('setting.bank_branch') }}</span>
            </p>
            <p>
                <b>Account Number: </b>
                <span>{{ config('setting.bank_account_number') }}</span>
            </p>
        </div>
    </div>
@endcomponent

<b>Deadline: </b><span>{{ config('setting.deadline_time') }} {{ $commissionsInfo['deadlineDay'] }}</span>
<i>If you not pay for us before the deadline, we will seek the intervention of law.</i>

<p class="thanks">Thanks,</p>
{{ config('app.name') }}
@endcomponent
