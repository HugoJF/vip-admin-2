import {schema} from 'normalizr';

export const user = new schema.Entity('users');

export const token = new schema.Entity('tokens', {
    user: user,
});