export const servers = (id) => ({
    loading: () => `servers.loading`,
    updating: (id2) => `servers.${id || id2}.updating`,
    deleting: (id2) => `servers.${id || id2}.deleting`,
    syncing: (id2) => `servers.${id || id2}.syncing`,
    rendering: (id2) => `servers.${id || id2}.rendering`,
});

export const modals = (id) => ({
    open: (id2) => `modals.${id || id2}.open`,
});