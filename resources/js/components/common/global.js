export const starRating = (calification = 0) => {
    const maxStars = 5;
    let str = '';
    for (let i = 1; i <= maxStars; i++) {
        if (calification >= i) {
            str += '<i class="bi bi-star-fill" style="color: darkorange"></i>'
        } else if (Math.round(calification) >= i) {
            str += '<i class="bi bi-star-half" style="color: darkorange"></i>'
        } else {
            str += '<i class="bi bi-star" style="color: darkorange"></i>'
        }
    }
    return str;
}
