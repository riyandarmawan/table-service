window.formatToIdr = (value) => {
    if (!value) return '';

    value = String(value).replace(/[^\d]/g, '');

    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
        minimumFractionDigits: 0,
    }).format(value);
}

window.chairCapacity = (value) => {
    if (!value) return '';

    value = String(value).replace(/[^\d]/g, '');

    return `${value} Orang`
}

// Function to format and convert to an integer
window.formatToInteger = (value) => {
    // Remove all non-digit characters
    const digitsOnly = value.toString().replace(/\D/g, '');
    // Convert the cleaned string back to an integer
    return parseInt(digitsOnly, 10) || 0; // Default to 0 if invalid
};
