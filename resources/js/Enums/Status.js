export const STATUS = {
    DRAFT: 'Draft',
    PENDING: 'Pending',
    COMPLETED: 'Completed',
};

// Convert object to an array of objects
export const statusOptions = Object.entries(STATUS).map(([value, label]) => ({
    value: value,
    label,
}));
