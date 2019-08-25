import React from "react";
import {useField} from "react-final-form-hooks";
import {Input} from "reactstrap";

export default function useInputField(type, name, form, props) {
    const field = useField(name, form);

    const component = <Input
        {...field.input}
        type={type}
        {...props}
    />;

    return [field, component];
}