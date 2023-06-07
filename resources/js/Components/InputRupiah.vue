<template>
    <money3 class="form-control" v-model.number="amount" v-bind="config"></money3>{{ amount }} {{ typeof (amount) }}
</template>
  
<script>
import { Money3Component } from 'v-money3'

export default {
    components: { money3: Money3Component },
    data() {
        return {
            amount: '',
            config: {
                masked: false,
                prefix: 'Rp. ',
                suffix: '',
                thousands: '.',
                decimal: ',',
                precision: 0,
                disableNegative: true,
                disabled: false,
                min: null,
                max: 999999999999,
                allowBlank: false,
                minimumNumberOfCharacters: 0,
                shouldRound: true,
                focusOnRight: false,
            }
        }
    }
}
</script>