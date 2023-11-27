export default {
    formatUtcDate(utcDate) {
        let date = new Date(utcDate);
        let values = [date.getMonth() + 1, date.getDate(), date.getFullYear()]

        return values.join(' / ');
    }
}
