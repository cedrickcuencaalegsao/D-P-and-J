import React from "react";
import { Button } from "./Button";
import { ComponentMeta, ComponentStory } from "@storybook/react";

export default {
  title: "Atoms/Button",
  component: Button,
  argTypes: {
    onclick: { Action: true },
  },
} as ComponentMeta<typeof Button>;

const defaultArgs = {
  children: "Button",
  type: "primary",
};

const Template: ComponentMeta<typeof Button> = (args) => <Button {...args} />;

export const Primary = Template.bind({});
Primary.args = {
  ...defaultArgs,
};

export const Secondary = Template.bind({});
Secondary.args = {
  ...defaultArgs,
  type: "secondary",
};

export const Large = Template.bind({});
Large.args = {
  ...defaultArgs,
  size: "large",
};

export const Small = Template.bind({});
Small.args = {
  ...defaultArgs,
  size: "small",
};
