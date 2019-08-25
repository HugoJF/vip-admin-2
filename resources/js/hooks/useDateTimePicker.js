import React from "react";
import {useField} from "react-final-form-hooks";
import moment from "moment/moment";
import {DateTimePicker} from "react-widgets";

let props = {
    max: new Date(2099, 11, 31),
    date: true,
    time: true,
    format: 'dddd, MMMM Do YYYY, h:mm:ss',
};

export default function useDateTimePicker(name, form, props = {}) {
    const field = useField(name, form);

    const component = <DateTimePicker
        id={field.input.name}
        onChange={field.input.onChange}
        value={field.input.value ? moment(field.input.value).toDate() : undefined}
        {...props}
    />;

    return [field, component];
}